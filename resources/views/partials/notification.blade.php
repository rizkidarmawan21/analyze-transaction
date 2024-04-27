{{-- Alert notification --}}
<style>
    .fade-out {
        transition: opacity 1s;
        opacity: 0;
    }
</style>


@if (session('success'))
   <div class="w-[350px] h-[80px] rounded-lg bg-teal-500 flex items-center px-3 fixed z-99999 right-2 top-2" role="alert">
    <div class="flex justify-start items-center gap-3">
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="#fff" stroke="currentColor"
                viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                <path
                    d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z" />
            </svg>
        </span>

        <div class="text-white">
            <label class="font-bold text-xl">
                Success !
            </label>
            <p>
                {{ session('success') }}
            </p>
        </div>
    </div>
</div>
@endif

@if (session('failed'))
    <div class="w-[350px] h-[80px] rounded-lg bg-rose-500 flex items-center px-3 fixed z-99999 right-2 top-2" role="alert">
        <div class="flex justify-start items-center gap-3">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="#fff" stroke="currentColor"
                    viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path
                        d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" />
                </svg>
            </span>

            <div class="text-white">
                <label class="font-bold text-xl">
                    Failed !
                </label>
                <p>
                    {{ session('failed') }}
                </p>
            </div>
        </div>
    </div>
@endif

<script>
    setTimeout(() => {
        document.querySelectorAll('[role="alert"]').forEach((alert) => {
            alert.classList.add('fade-out');
            setTimeout(() => {
                alert.remove();
            }, 1000); // Wait for the transition to finish before removing the element
        });
    }, 3000);
</script>