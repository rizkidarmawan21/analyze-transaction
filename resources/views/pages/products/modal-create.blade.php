<div x-show="modalCreate" x-cloak>
    <div class="absolute inset-0 overflow-y-auto z-9999" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 flex items-center justify-center min-h-screen pb-20 text-center">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 transition-opacity bg-black bg-opacity-75"></div>
            </div>
            <div
                class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="p-5 bg-white dark:bg-boxdark">
                    <div class="">
                        <div class="flex items-center justify-between">
                            <h3 class="text-2xl font-medium leading-6 text-gray-900 dark:text-white" id="modal-title">
                                Add Product
                            </h3>
                            <button class="p-2 rounded-lg hover:bg-slate-100" @click="modalCreate = false">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current"
                                    viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path
                                        d="M376.6 84.5c11.3-13.6 9.5-33.8-4.1-45.1s-33.8-9.5-45.1 4.1L192 206 56.6 43.5C45.3 29.9 25.1 28.1 11.5 39.4S-3.9 70.9 7.4 84.5L150.3 256 7.4 427.5c-11.3 13.6-9.5 33.8 4.1 45.1s33.8 9.5 45.1-4.1L192 306 327.4 468.5c11.3 13.6 31.5 15.4 45.1 4.1s15.4-31.5 4.1-45.1L233.7 256 376.6 84.5z" />
                                </svg>
                            </button>
                        </div>
                        <div class="mt-5">
                            <form
                                :action="isEdit ? '{{ url('') }}' + '/products/' + selectedValue?.id :
                                    '{{ route('products.store') }}'"
                                method="POST" class="space-y-3" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="_method" :value="isEdit ? 'PUT' : 'POST'">
                                <div class="space-y-2">
                                    <img x-show="isEdit" :src="'{{ url('') }}/storage/'+selectedValue.image_path" alt="" class="w-20 h-20 object-cover">
                                    <x-input-label for="image" value="Image Product" class="!text-lg" />
                                    <x-text-input id="image" name="image" type="file" placeholder="Upload File"
                                        accept="image/jpeg,image/png,image/jpg" class="!py-2 !px-3" />
                                    <span>
                                        <p class="text-sm text-yellow-500">
                                            Only <strong>.jpg, .jpeg, .png</strong> file format is allowed
                                        </p>
                                    </span>
                                    <x-input-error :messages="$errors->get('file_name')" class="mt-2" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="name" value="Name" class="!text-lg" required />
                                    <x-text-input id="name" name="name" type="text"
                                        x-bind:value="isEdit ? selectedValue.name : ''" placeholder="Insert Name"
                                        class="!py-2 !px-3" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="description" value="Description" class="!text-lg" />
                                    <x-text-input id="description" name="description" type="text"
                                        x-bind:value="isEdit ? selectedValue.description : ''"
                                        placeholder="Insert Description" class="!py-2 !px-3" />
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="price" value="Price" class="!text-lg" />
                                    <x-text-input id="price" name="price" type="number"
                                        x-bind:value="isEdit ? selectedValue.price : ''" placeholder="Insert Price"
                                        class="!py-2 !px-3" />
                                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                </div>

                                <div class="space-y-2" x-data="{ switcherToggle: false }" x-init="$watch('isEdit', value => { if (value) switcherToggle = selectedValue.is_show == 1 ? true : false; })">
                                    <x-input-label for="is_show" value="Show to Dashboard" class="!text-lg" />
                                    <input type="hidden" name="is_show"
                                        x-bind:value="switcherToggle">
                                    <div class="flex flex-col gap-5.5">
                                        <div>
                                            <label for="toggle3" class="flex cursor-pointer select-none items-center">
                                                <div class="relative">
                                                    <input type="checkbox" id="toggle3" class="sr-only"
                                                        @change="switcherToggle = !switcherToggle" />
                                                    <div
                                                        class="block h-8 w-14 rounded-full bg-meta-9 dark:bg-[#5A616B]">
                                                    </div>
                                                    <div :class="switcherToggle &&
                                                        '!right-1 !translate-x-full !bg-primary dark:!bg-white'"
                                                        class="dot absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition">
                                                        <span :class="switcherToggle && '!block'"
                                                            class="hidden text-white dark:text-bodydark">
                                                            <svg class="fill-current stroke-current" width="11"
                                                                height="8" viewBox="0 0 11 8" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M10.0915 0.951972L10.0867 0.946075L10.0813 0.940568C9.90076 0.753564 9.61034 0.753146 9.42927 0.939309L4.16201 6.22962L1.58507 3.63469C1.40401 3.44841 1.11351 3.44879 0.932892 3.63584C0.755703 3.81933 0.755703 4.10875 0.932892 4.29224L0.932878 4.29225L0.934851 4.29424L3.58046 6.95832C3.73676 7.11955 3.94983 7.2 4.1473 7.2C4.36196 7.2 4.55963 7.11773 4.71406 6.9584L10.0468 1.60234C10.2436 1.4199 10.2421 1.1339 10.0915 0.951972ZM4.2327 6.30081L4.2317 6.2998C4.23206 6.30015 4.23237 6.30049 4.23269 6.30082L4.2327 6.30081Z"
                                                                    fill="" stroke="" stroke-width="0.4">
                                                                </path>
                                                            </svg>
                                                        </span>
                                                        <span :class="switcherToggle && 'hidden'">
                                                            <svg class="h-4 w-4 stroke-current" fill="none"
                                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <x-input-error :messages="$errors->get('is_show')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="pt-7">
                                    <x-primary-button class="!rounded-full !py-3">
                                         <p x-text="isEdit ? 'Update' : 'Create'"></p>
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
