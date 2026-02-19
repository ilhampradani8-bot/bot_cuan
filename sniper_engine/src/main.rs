use sqlx::{sqlite::SqlitePoolOptions, Row, Pool, Sqlite};
use std::env;
use dotenv::dotenv;
use std::time::Duration;
use reqwest::Client;
use serde::Deserialize;
use chrono::{Utc, TimeZone};

// Struktur Respon Indodax
#[derive(Debug, Deserialize)]
struct IndodaxTickerResponse {
    ticker: IndodaxTickerData,
}

#[derive(Debug, Deserialize)]
struct IndodaxTickerData {
    last: String,
    vol_idr: String,
}

#[tokio::main]
async fn main() -> Result<(), Box<dyn std::error::Error>> {
    dotenv().ok();
    
    println!("🔥 SNIPER ENGINE: MARKET COLLECTOR MODE STARTED");
    
    // 1. KONEKSI DATABASE MARKET (Gudang Data)
    let db_market_url = env::var("MARKET_DB_URL").expect("MARKET_DB_URL wajib ada di .env");
    let pool_market = SqlitePoolOptions::new()
        .max_connections(5)
        .connect(&db_market_url)
        .await?;

    // 2. DAFTAR KOIN WAJIB (Default Assets)
    // Koin ini akan SELALU dicatat harganya, walaupun tidak ada user yang main.
    // Tambahkan koin lain di sini jika mau (cth: "doge_idr", "eth_idr")
    let watch_list = vec!["btc_idr", "eth_idr", "doge_idr", "sol_idr", "xrp_idr"];

    let http_client = Client::new();

    // 3. LOOPING ABADI (Setiap 10 Detik)
    loop {
        let now = Utc::now();
        println!("\n⏰ SCANNING MARKET... [{}]", now.format("%H:%M:%S"));

        // Hitung Awal Menit (Untuk ID Candle)
        // Contoh: 14:05:23 -> Candle ID-nya 14:05:00
        let current_minute_timestamp = Utc.timestamp_opt(now.timestamp() / 60 * 60, 0).unwrap().timestamp();

        for pair in &watch_list {
            // Format Indodax: btcidr (tanpa underscore)
            let pair_api = pair.replace("_", ""); 
            let url = format!("https://indodax.com/api/ticker/{}", pair_api);

            match http_client.get(&url).send().await {
                Ok(resp) => {
                    if let Ok(json) = resp.json::<IndodaxTickerResponse>().await {
                        let current_price: f64 = json.ticker.last.parse().unwrap_or(0.0);
                        let volume: f64 = json.ticker.vol_idr.parse().unwrap_or(0.0);

                        println!("   👉 {}: Rp {}", pair.to_uppercase(), current_price);

                        // --- LOGIKA PEMBENTUKAN CANDLE (OHLC) ---
                        
                        // Cek apakah candle untuk menit ini SUDAH ADA?
                        let existing_candle = sqlx::query(
                            "SELECT open, high, low FROM candles_1m WHERE pair = ? AND time = ?"
                        )
                        .bind(pair)
                        .bind(current_minute_timestamp)
                        .fetch_optional(&pool_market)
                        .await?;

                        if let Some(row) = existing_candle {
                            // UPDATE (Candle Sedang Berjalan)
                            let old_high: f64 = row.get("high");
                            let old_low: f64 = row.get("low");

                            let new_high = if current_price > old_high { current_price } else { old_high };
                            let new_low = if current_price < old_low { current_price } else { old_low };

                            sqlx::query(
                                "UPDATE candles_1m SET high = ?, low = ?, close = ?, volume = ? WHERE pair = ? AND time = ?"
                            )
                            .bind(new_high)
                            .bind(new_low)
                            .bind(current_price) // Close selalu harga terakhir
                            .bind(volume)
                            .bind(pair)
                            .bind(current_minute_timestamp)
                            .execute(&pool_market)
                            .await?;
                            
                        } else {
                            // INSERT BARU (Detik pertama di menit baru)
                            // Open, High, Low, Close = Harga Sekarang semua
                            sqlx::query(
                                "INSERT INTO candles_1m (pair, time, open, high, low, close, volume) VALUES (?, ?, ?, ?, ?, ?, ?)"
                            )
                            .bind(pair)
                            .bind(current_minute_timestamp)
                            .bind(current_price) // Open
                            .bind(current_price) // High
                            .bind(current_price) // Low
                            .bind(current_price) // Close
                            .bind(volume)
                            .execute(&pool_market)
                            .await?;
                        }

                    } else {
                        println!("      ❌ JSON Error: {}", pair);
                    }
                }
                Err(e) => println!("      ❌ Koneksi Error: {}", e),
            }
        }

        println!("   💾 Data tersimpan. Istirahat 10 detik...");
        tokio::time::sleep(Duration::from_secs(10)).await;
    }
}