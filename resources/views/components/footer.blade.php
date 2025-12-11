<footer class="bg-white border-t mt-16">
  <div class="max-w-7xl mx-auto px-6 py-12 grid md:grid-cols-3 gap-10">

    <div>
      <h3 class="text-xl font-bold text-textdark">SweetMart</h3>
      <p class="text-gray-600 mt-2 max-w-xs">
        Fresh desserts, local bakers, and a warm experience delivered to your home.
      </p>
    </div>

    <div>
      <h4 class="font-semibold text-textdark mb-3">Explore</h4>
      <ul class="text-gray-600 space-y-2">
        <li><a href="/" class="hover:underline">Home</a></li>
        <li><a href="/products" class="hover:underline">Products</a></li>
        <li><a href="/categories" class="hover:underline">Categories</a></li>
      </ul>
    </div>

    <div>
      <h4 class="font-semibold text-textdark mb-3">Newsletter</h4>
      <input class="w-full border px-3 py-2 rounded-lg" placeholder="Your email" />
      <button class="w-full bg-sweet-400 hover:bg-sweet-500 text-white py-2 rounded-lg mt-3">
        Subscribe
      </button>
    </div>

  </div>

  <div class="text-center py-4 border-t text-gray-400 text-sm">
    © {{ date('Y') }} SweetMart — All rights reserved.
  </div>
</footer>