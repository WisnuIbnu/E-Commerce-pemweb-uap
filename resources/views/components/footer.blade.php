<footer class="bg-tumbloo-darker text-tumbloo-gray border-t border-tumbloo-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">

            <div class="md:col-span-1">
                <img src="{{ asset('images/logo.png') }}" alt="Tumbloo" class="h-10 w-auto mb-4 brightness-0 invert">
                <p class="text-sm text-tumbloo-gray-light mb-4">
                    Platform marketplace terpercaya untuk membeli dan menjual Tumbler terbaik di seluruh dunia.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-tumbloo-gray hover:text-tumbloo-white transition" aria-label="Twitter">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                    </a>
                    <a href="#" class="text-tumbloo-gray hover:text-tumbloo-white transition" aria-label="Instagram">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z" />
                            <path
                                d="M12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a3.999 3.999 0 110-7.998 3.999 3.999 0 010 7.998z" />
                        </svg>
                    </a>
                    <a href="#" class="text-tumbloo-gray hover:text-tumbloo-white transition" aria-label="Discord">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20.317 4.37a19.791 19.791 0 00-4.885-1.515.074.074 0 00-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 00-5.487 0 12.64 12.64 0 00-.617-1.25.077.077 0 00-.079-.037A19.736 19.736 0 003.677 4.37a.07.07 0 00-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 00.031.057 19.9 19.9 0 005.993 3.03.078.078 0 00.084-.028c.462-.63.874-1.295 1.226-1.994a.076.076 0 00-.041-.106 13.107 13.107 0 01-1.872-.892.077.077 0 01-.008-.128 10.2 10.2 0 00.372-.292.074.074 0 01.077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 01.078.01c.12.098.246.198.373.292a.077.077 0 01-.006.127 12.299 12.299 0 01-1.873.892.077.077 0 00-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 00.084.028 19.839 19.839 0 006.002-3.03.077.077 0 00.032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 00-.031-.03z" />
                        </svg>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-tumbloo-white uppercase tracking-wider mb-4">Platform</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('marketplace') }}" class="text-sm hover:text-tumbloo-white transition">Marketplace</a></li>
                    <li><a href="{{ route('pricing') }}" class="text-sm hover:text-tumbloo-white transition">Harga</a>
                    </li>
                    <li><a href="{{ route('sell') }}" class="text-sm hover:text-tumbloo-white transition">Jual Brand</a>
                    </li>
                    <li><a href="{{ route('faq') }}" class="text-sm hover:text-tumbloo-white transition">FAQ</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-tumbloo-white uppercase tracking-wider mb-4">Bantuan</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('support') }}" class="text-sm hover:text-tumbloo-white transition">Pusat
                            Bantuan</a></li>
                    <li><a href="{{ route('guide') }}" class="text-sm hover:text-tumbloo-white transition">Panduan
                            Pembeli</a></li>
                    <li><a href="{{ route('sellerguide') }}" class="text-sm hover:text-tumbloo-white transition">Panduan
                            Penjual</a></li>
                    <li><a href="{{ route('safety') }}" class="text-sm hover:text-tumbloo-white transition">Keamanan
                            Transaksi</a></li>
                    <li><a href="{{ route('contact') }}" class="text-sm hover:text-tumbloo-white transition">Hubungi
                            Kami</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-tumbloo-white uppercase tracking-wider mb-4">Legal</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('terms') }}" class="text-sm hover:text-tumbloo-white transition">Syarat &
                            Ketentuan</a></li>
                    <li><a href="{{ route('privacy') }}" class="text-sm hover:text-tumbloo-white transition">Kebijakan
                            Privasi</a></li>
                    <li><a href="{{ route('refund') }}" class="text-sm hover:text-tumbloo-white transition">Kebijakan
                            Pengembalian</a></li>
                    <li><a href="{{ route('cookies') }}" class="text-sm hover:text-tumbloo-white transition">Kebijakan
                            Cookie</a></li>
                </ul>
            </div>
        </div>

        <div class="pt-8 mt-8 border-t border-tumbloo-black">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-tumbloo-gray-dark">
                    &copy; {{ date('Y') }} Tumbloo. All rights reserved.
                </p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <span class="text-xs text-tumbloo-gray-dark">🇮🇩 Made in Indonesia</span>
                    <span class="text-xs text-tumbloo-gray-dark">•</span>
                    <a href="{{ route('sitemap') }}"
                        class="text-xs text-tumbloo-gray-dark hover:text-tumbloo-white transition">Sitemap</a>
                </div>
            </div>
        </div>
    </div>
</footer>