<div
    class="confirmModal w-full h-screen absolute inset-0 z-99999 bg-black bg-opacity-75 transition-opacity flex items-center justify-center hidden">
    <div class="w-[90%] lg:w-1/2 py-5 bg-white rounded-xl flex flex-col items-center justify-center">
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-500" fill="currentColor"
                viewBox="0 0 512 512">
                <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                <path
                    d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z" />
            </svg>
        </span>
        <h2 class="mt-5 text-2xl font-semibold text-slate-800">
            Are you sure ?
        </h2>
        <p class="text-lg" x-text="confirmDesc"></p>
        <div class="flex gap-3 mt-5">
            <button class="px-5 py-2 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-colors"
                @click="document.querySelector('.confirmModal').classList.add('hidden');">Cancel</button>
            <form :action="confirmUrl" :method="confirmMethod != 'GET' ? 'POST' : 'GET'">
                @csrf
                <input type="hidden" name="_method" :value="confirmMethod">
                <button class="px-5 py-2 bg-primary text-white rounded-lg hover:bg-primary/60 transition-colors">
                    Yes,
                </button>
            </form>
        </div>
    </div>
</div>
