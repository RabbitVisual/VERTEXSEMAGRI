<x-iluminacao::card>
    <div x-data="{
        lat: '{{ $latitude ?? '' }}',
        lng: '{{ $longitude ?? '' }}',
        convertDMS(type) {
            let input = type === 'lat' ? this.lat : this.lng;
            let regex = /(\d+)[°\s]+(\d+)[\x27\s]+(\d+(?:\.\d+)?)[\x22\s]*([NSEWnsew])?/;
            let match = input.match(regex);
            if (match) {
                let deg = parseFloat(match[1]);
                let min = parseFloat(match[2]);
                let sec = parseFloat(match[3]);
                let dir = match[4] ? match[4].toUpperCase() : null;
                let dec = deg + min/60 + sec/3600;
                if (dir === 'S' || dir === 'W') dec = -dec;
                if (type === 'lat') this.lat = dec.toFixed(6);
                else this.lng = dec.toFixed(6);
            }
        }
    }">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-100 dark:border-slate-700/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400">
                    <x-icon name="location-dot" class="w-5 h-5" />
                </div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Georreferenciamento</h3>
            </div>
            <div class="px-3 py-1 bg-slate-100 dark:bg-slate-900 rounded-lg text-[10px] font-bold text-slate-400 uppercase tracking-widest border border-slate-200 dark:border-slate-700">
                Decimal ou DMS
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 px-1">Latitude</label>
                <div class="relative">
                    <input type="text" name="latitude" x-model="lat" @blur="convertDMS('lat')"
                        placeholder="-12.2336 ou 12° 14' 01\" S"
                        class="w-full px-5 py-3 rounded-2xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-mono text-sm leading-relaxed">
                    <div class="absolute left-0 top-0 h-full flex items-center pl-4 pointer-events-none opacity-20">
                        <x-icon name="arrows-up-down" class="w-4 h-4" />
                    </div>
                </div>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 px-1">Longitude</label>
                <div class="relative">
                    <input type="text" name="longitude" x-model="lng" @blur="convertDMS('lng')"
                        placeholder="-38.7454 ou 38° 44' 43\" W"
                        class="w-full px-5 py-3 rounded-2xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-mono text-sm leading-relaxed">
                    <div class="absolute left-0 top-0 h-full flex items-center pl-4 pointer-events-none opacity-20">
                        <x-icon name="arrows-left-right" class="w-4 h-4" />
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-700 shadow-inner">
            <x-map
                latitude-field="latitude"
                longitude-field="longitude"
                nome-mapa-field="nome_mapa"
                height="400px"
                :latitude="$latitude ?? '-12.2336'"
                :longitude="$longitude ?? '-38.7454'"
                zoom="14"
                icon-type="ponto_luz"
            />
        </div>
    </div>
</x-iluminacao::card>
