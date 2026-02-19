<?php
// config/indicators.php
return [
    'rsi' => ['name' => 'RSI (Relative Strength Index)', 'default' => 30],
    'macd' => ['name' => 'MACD (Trend)', 'default' => '12,26,9'],
    'vol_spike' => ['name' => 'Volume Spike (>300%)', 'default' => '3x'],
    'bollinger' => ['name' => 'Bollinger Bands (Squeeze)', 'default' => '2.0'],
    'ma_cross' => ['name' => 'MA Cross (Golden Cross)', 'default' => '50,200']
];
?>