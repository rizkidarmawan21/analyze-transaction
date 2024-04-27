<div x-show="modalCreate" x-cloak>
    <div class="absolute inset-0 z-9999 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 flex items-center justify-center min-h-screen pb-20 text-center">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-black bg-opacity-75 transition-opacity"></div>
            </div>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white dark:bg-boxdark p-5">
                    <div class="">
                        <div class="flex justify-between items-center">
                            <h3 class="text-2xl font-medium leading-6 text-gray-900 dark:text-white" id="modal-title">
                                Create User
                            </h3>
                            <button class="hover:bg-slate-100 p-2 rounded-lg" @click="modalCreate = false">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current"
                                    viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path
                                        d="M376.6 84.5c11.3-13.6 9.5-33.8-4.1-45.1s-33.8-9.5-45.1 4.1L192 206 56.6 43.5C45.3 29.9 25.1 28.1 11.5 39.4S-3.9 70.9 7.4 84.5L150.3 256 7.4 427.5c-11.3 13.6-9.5 33.8 4.1 45.1s33.8 9.5 45.1-4.1L192 306 327.4 468.5c11.3 13.6 31.5 15.4 45.1 4.1s15.4-31.5 4.1-45.1L233.7 256 376.6 84.5z" />
                                </svg>
                            </button>
                        </div>
                        <div class="mt-10">
                            <form action="{{ route('users.store') }}" method="POST" class="space-y-3">
                                @csrf
                                <div class="space-y-2">
                                    <x-input-label for="name" value="Name" class="!text-lg" />
                                    <x-text-input id="name" name="name" type="text" placeholder="Insert Name"
                                        class="!py-2 !px-3" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                <div class="space-y-2">
                                    <x-input-label for="email" value="Email" class="!text-lg" />
                                    <x-text-input id="email" name="email" type="email"
                                        placeholder="Insert Email Address" class="!py-2 !px-3" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                <div class="space-y-2">
                                    <x-input-label for="password" value="password" class="!text-lg" />
                                    <x-text-input id="password" name="password" type="password"
                                        placeholder="Insert Password" class="!py-2 !px-3" />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>
                                <div class="pt-10">
                                    <x-primary-button class="!rounded-full !py-3">
                                        Create
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
