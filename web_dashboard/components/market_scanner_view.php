<div id="market-scanner-container" class="flex flex-col h-full">
    <div class="bg-slate-50 px-5 py-4 border-b border-slate-200 flex justify-between items-center">
        <h3 class="font-bold text-slate-800 text-xs uppercase tracking-wider">3. Live Scanner</h3>
        <div class="flex items-center gap-2">
            <div id="market-pulse" class="w-2 h-2 rounded-full bg-slate-300 transition-colors duration-500"></div>
            <span class="text-[9px] font-bold text-slate-500 uppercase">DB Feed</span>
        </div>
    </div>

    <div class="flex-grow overflow-auto scrollbar-hide">
        <table class="w-full text-left border-collapse">
            <thead class="bg-white sticky top-0 z-10 text-slate-400 text-[9px] font-bold uppercase border-b border-slate-100 shadow-sm">
                <tr>
                    <th class="p-3 pl-5">Pair</th>
                    <th class="p-3 text-right">Price (IDR)</th>
                    <th class="p-3 pr-5 text-right">Vol (24h)</th>
                </tr>
            </thead>
            <tbody id="market-tbody" class="divide-y divide-slate-50 text-[10px]">
                <tr>
                    <td colspan="3" class="p-10 text-center text-slate-400 italic animate-pulse">
                        Scanning market data...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>