<section class="sweet-gradient py-16">
  <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">

    {{-- TEXT --}}
    <div>
      <h1 class="text-5xl font-extrabold text-textdark leading-tight">
        SweetMart — Fresh Desserts Everyday
      </h1>

      <p class="mt-5 text-gray-600 text-lg max-w-xl">
        Pesan dessert premium dari baker rumahan. Fresh, lokal, dan dikirim langsung ke pintu rumahmu.
      </p>

      <div class="mt-6 flex gap-3">
        <a href="{{ route('products.index') }}"
           class="bg-sweet-400 hover:bg-sweet-500 text-white px-6 py-3 rounded-xl shadow font-medium">
          Shop Desserts
        </a>
        <a href="{{ route('categories.index') }}"
           class="border border-gray-300 hover:bg-gray-100 px-6 py-3 rounded-xl text-gray-700 font-medium">
          Explore Categories
        </a>
      </div>
    </div>

    {{-- IMAGE MOCKUP --}}
    <div class="sweet-shadow rounded-3xl overflow-hidden mx-auto">
      <img src="{{ asset('images/hero-dessert.jpg') }}"
           class="rounded-3xl object-cover w-full h-[420px]" />
    </div>

  </div>
</section>