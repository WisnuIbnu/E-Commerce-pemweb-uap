<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lacak Pesanan #{{ $transaction->code }}
        </h2>
    </x-slot>

    <style>
        /* Animasi garis progress */
        @keyframes fillProgress {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }

        .animate-progress {
            animation: fillProgress 0.8s ease-out forwards;
        }

        /* Animasi bullet muncul */
        @keyframes popBullet {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-bullet {
            animation: popBullet 0.4s ease-out forwards;
        }
    </style>


    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- STATUS PENGIRIMAN --}}
            <div class="bg-white p-6 shadow rounded-xl">
                <h3 class="font-bold text-lg mb-6">Status Pengiriman</h3>

                @php
                // Mapping status ke step progress
                $payment = strtolower($transaction->payment_status);

                $stepsMap = [
                'pending' => 0,
                'waiting_confirmation' => 1,
                'paid' => 2,
                'processing' => 2,
                'shipped' => 3,
                'delivered' => 3,
                'completed' => 3,
                ];

                $labels = [
                'Diproses',
                'Dikemas',
                'Dalam Perjalanan',
                'Diterima',
                ];

                $current = $stepsMap[$payment] ?? 0;
                $maxIndex = count($labels) - 1;
                if ($current > $maxIndex) $current = $maxIndex;

                // lebar garis oranye pakai kelas Tailwind (tanpa inline style)
                $widthClass = match($current) {
                0 => 'w-0',
                1 => 'w-1/3',
                2 => 'w-2/3',
                default => 'w-full',
                };
                @endphp

                <div class="relative w-full px-12 mt-8">

                    {{-- base line abu-abu --}}
                    <div class="absolute top-5 left-0 w-full h-[4px] bg-gray-300 rounded-full"></div>

                    {{-- garis progress oranye --}}
                    <div class="absolute top-5 left-0 h-[4px] bg-orange-500 rounded-full {{ $widthClass }} animate-progress"></div>

                    {{-- step bullets + label --}}
                    <div class="flex justify-between relative z-10 w-full">
                        @foreach ($labels as $i => $label)
                        <div class="flex flex-col items-center w-1/4 text-center">

                            {{-- bullet --}}
                            <div class="h-10 w-10 rounded-full flex items-center justify-center
                            {{ $i <= $current ? 'bg-orange-500 animate-bullet' : 'bg-gray-300' }}">
                            </div>


                            {{-- label --}}
                            <p class="mt-3 text-sm
                        {{ $i <= $current ? 'text-orange-600 font-semibold' : 'text-gray-500' }}">
                                {{ $label }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6 text-gray-700 text-sm">
                    <strong>Kurir:</strong> {{ $transaction->shipping ?? '-' }} <br>
                    <strong>No. Resi:</strong> {{ $transaction->tracking_number ?? '-' }}
                </div>
            </div>

            {{-- LOKASI PENGIRIMAN --}}
            <div class="bg-white p-6 shadow rounded-xl">
                <h3 class="font-bold text-lg mb-4">Lokasi Pengiriman Saat Ini</h3>

                <div id="map" style="width: 100%; height: 350px; border-radius: 12px"></div>

                {{-- Leaflet CSS --}}
                <link rel="stylesheet"
                    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
                    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
                    crossorigin="" />

                {{-- Leaflet JS --}}
                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
                    crossorigin=""></script>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {

                        // Ambil kota pembeli dari database
                        const buyerCity = "{{ $transaction->city ?? 'Jakarta' }}".toLowerCase();

                        // Koordinat default
                        let lat = -6.200000;
                        let lng = 106.816666;

                        // Mapping kota → koordinat
                        const cityCoords = {
                            'jakarta': {
                                lat: -6.200000,
                                lng: 106.816666
                            },
                            'bandung': {
                                lat: -6.917464,
                                lng: 107.619123
                            },
                            'surabaya': {
                                lat: -7.257472,
                                lng: 112.752088
                            },
                        };

                        if (cityCoords[buyerCity]) {
                            lat = cityCoords[buyerCity].lat;
                            lng = cityCoords[buyerCity].lng;
                        }

                        // Inisialisasi peta
                        const map = L.map('map').setView([lat, lng], 12);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '&copy; OpenStreetMap contributors'
                        }).addTo(map);

                        L.marker([lat, lng])
                            .addTo(map)
                            .bindPopup('Kurir sedang menuju alamat Anda')
                            .openPopup();
                    });
                </script>

            </div>
        </div>
    </div>
    </div>
</x-app-layout>