use sqlx::{sqlite::SqlitePoolOptions, FromRow};
use std::env;
use dotenv::dotenv;

// 1. Definisikan Struktur Data
#[derive(Debug, FromRow)]
struct BotSetting {
    id: i64,          // Kita pakai ini sekarang
    user_id: i64,
    pair: String,
    target_profit: f64,
    is_active: i64,   // Kita pakai ini sekarang
}

#[tokio::main]
async fn main() -> Result<(), Box<dyn std::error::Error>> {
    // A. Load Environment
    dotenv().ok();
    
    // B. Setup Koneksi Database
    let database_url = env::var("DATABASE_URL").expect("DATABASE_URL must be set in .env");
    
    println!("🔌 Menghubungkan ke Database...");

    let pool = SqlitePoolOptions::new()
        .max_connections(5)
        .connect(&database_url)
        .await?;

    println!("✅ Koneksi Database Berhasil!");

    // C. Coba Baca Data dari Tabel 'bot_settings'
    // Kita ambil SEMUA bot (aktif & tidak aktif) untuk pengecekan
    let all_bots = sqlx::query_as::<_, BotSetting>(
        "SELECT id, user_id, pair, target_profit, is_active FROM bot_settings"
    )
    .fetch_all(&pool)
    .await?;

    println!("------------------------------------------------");
    println!("🤖 SCANNING DATABASE...");
    println!("------------------------------------------------");

    if all_bots.is_empty() {
        println!("⚠️ Belum ada data bot sama sekali.");
    } else {
        for bot in all_bots {
            let status = if bot.is_active == 1 { "✅ AKTIF" } else { "💤 MATI" };
            
            println!("📄 Config ID: {}", bot.id);
            println!("   👤 User ID: {}", bot.user_id);
            println!("   Coin Pair: {}", bot.pair);
            println!("   Target Profit: {}%", bot.target_profit);
            println!("   Status: {}", status);
            println!("------------------------------------------------");
        }
    }

    Ok(())
}