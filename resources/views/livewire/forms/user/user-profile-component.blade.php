<div x-data="{ openTab: 1 }" class="w-full h-screen bg-white">
    <div class="w-full flex border-b bg-white border-gray-200 sticky top-12">
        <div class="w-96">&nbsp;</div>
        <nav class="flex items-end pt-10">
            <ul class="flex list-none">
                <li>
                    <button @click="openTab = 1" :class="{ 'border-red-500':  openTab == 1, 'hover:border-gray-400':  openTab != 1}" class="flex h-full pb-3 border-b-2 px-4 py-1 text-base font-bold text-black transition duration-500 ease-in-out transform focus:shadow-outline focus:outline-none">
                        <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mx-2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Personal Details
                    </button>
                </li>
                <li>
                    <button @click="openTab = 2" :class="{ 'border-red-500':  openTab == 2, 'hover:border-gray-400':  openTab != 2}" class="flex h-full pb-3 border-b-2 px-4 py-1 text-base font-bold text-black transition duration-500 ease-in-out transform focus:shadow-outline focus:outline-none">
                        <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mx-2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        Contacts
                    </button>
                </li>
                @if ($user->role_id == 2)
                    <li>
                        <button @click="openTab = 3" :class="{ 'border-red-500':  openTab == 3, 'hover:border-gray-400':  openTab != 3}" class="flex h-full pb-3 border-b-2 px-4 py-1 text-base font-bold text-black transition duration-500 ease-in-out transform focus:shadow-outline focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-2" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                             </svg>
                            Guardian Details
                        </button>
                    </li>
                    <li>
                        <button @click="openTab = 4" :class="{ 'border-red-500':  openTab == 4, 'hover:border-gray-400':  openTab != 4}" class="flex h-full pb-3 border-b-2 px-4 py-1 text-base font-bold text-black transition duration-500 ease-in-out transform focus:shadow-outline focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-2" width="22" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"></path>
                                <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"></path>
                             </svg>
                            Education Background
                        </button>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    <div class="flex flex-1">
        <div class="max-w-sm sm:px-6 lg:px-12">
            <div class="flex flex-col">
                <img class="mt-6 w-96 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"/>
                <p class="mt-4 text-3xl font-semibold">{{ $user->name }}</p>
                <p class="mt-2 text-gray-400 text-xl">{{ $user->email }}</p>
                @can('update', $person)
                    <a href="{{ route('profile.show') }}" class="mt-4">
                        <button class="w-full px-5 py-1 border-2 border-gray-300 hover:bg-gray-100 rounded-md font-bold outline-none">
                            Edit Profile
                        </button>
                    </a>
                @endcan
            </div>
        </div>
        <div x-show="openTab == 1" class="sm:px-6 lg:px-8 w-full">
            <div class="my-6 text-lg font-semibold">Fullname</div>
            <div class="grid grid-cols-8 gap-6">
                <div class="mt-4 col-span-4">
                    <x-jet-label for="firstname" value="{{ __('First Name') }}" />
                    <x-jet-input wire:model.defer="person.firstname" id="firstname" class="block mt-1 w-full" type="text" name="firstname" readonly/>
                </div>
                <div class="mt-4 col-span-4">
                    <x-jet-label for="middlname" value="{{ __('Middle Name') }}" />
                    <x-jet-input wire:model.defer="person.middlename" id="year" class="block mt-1 w-full" type="text" name="middlname" readonly/>
                </div>
                <div class="mt-4 col-span-4">
                    <x-jet-label for="lastname" value="{{ __('Last Name') }}" />
                    <x-jet-input wire:model.defer="person.lastname" id="lastname" class="block mt-1 w-full" type="text" name="lastname" readonly/>
                </div>
                <div class="mt-4 col-span-4">
                    <x-jet-label for="suffix" value="{{ __('Suffix') }}" />
                    <x-jet-input wire:model.defer="person.suffix" id="year" class="block mt-1 w-full" type="text" name="suffix" readonly/>
                </div>
            </div>
            <div class="mt-12 mb-6 text-lg font-semibold">Other Details</div>
            <div class="grid grid-cols-8 gap-6">
                <div class="mt-4 col-span-4">
                    <x-jet-label for="gender" value="{{ __('Gender') }}" />
                    <x-jet-input wire:model.defer="detail.gender" id="gender" class="block mt-1 w-full" type="text" name="gender" readonly/>
                </div>
                <div class="mt-4 col-span-4">
                    <x-jet-label for="status" value="{{ __('Civil Status') }}" />
                    <x-jet-input wire:model.defer="detail.civil_status" id="status" class="block mt-1 w-full" type="text" name="status" readonly/>
                </div>
                <div class="mt-4 col-span-4">
                    <x-jet-label for="religion" value="{{ __('Religion') }}" />
                    <x-jet-input wire:model.defer="detail.religion" id="religion" class="block mt-1 w-full" type="text" name="religion" readonly/>
                </div>
                <div class="mt-4 col-span-4">
                    <x-jet-label for="birthdate" value="{{ __('Birthdate') }}" />
                    <x-jet-input wire:model.defer="detail.birthdate" id="birthdate" class="block mt-1 w-full" type="date" name="birthdate" readonly/>
                </div>
                <div class="mt-4 col-span-4">
                    <x-jet-label for="birthplace" value="{{ __('Birthplace') }}" />
                    <x-jet-input wire:model.defer="detail.birthplace" id="birthplace" class="block mt-1 w-full" type="text" name="birthplace" readonly/>
                </div>
                <div class="mt-4 col-span-4">
                    <x-jet-label for="nationality" value="{{ __('Nationality') }}" />
                    <x-jet-input wire:model.defer="country" id="country" class="block mt-1 w-full" type="text" name="country" readonly/>
                </div>
            </div>

            @if ($user->role_id == 2)
                <div class="mt-12 mb-6 text-lg font-semibold">Recent Activity</div>
                <div class="grid grid-cols-8 gap-6 mb-12">
                    @foreach ($this->registrations as $registration)
                        <div class="p-3 col-span-8 border-b border-gray-300">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="bg-gray-300 rounded-full p-2 mx-2">
                                        <svg class="" fill="none" stroke="currentColor" width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <a href="{{ route('pre.registration.view', ['regId' => $registration->id]) }}"><p class="hover:underline text-indigo-500">Registration ID: {{ $registration->id }}</p></a>
                                        <div class=""><span class="font-bold">Status:</span> {{ $registration->status->name }}</div>
                                    </div>
                                </div>
                                <p>{{ Carbon\Carbon::parse($registration->created_at)->format('F j, Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div x-show="openTab == 2" x-cloak class="sm:px-6 lg:px-8 w-full">
            <div class="my-6 text-lg font-semibold">Contacts</div>
            <div class="grid grid-cols-8 gap-6">
                <div class="mt-4 col-span-8">
                    <x-jet-label for="address" value="{{ __('Address') }}" />
                    <x-jet-input wire:model.defer="contact.address" id="address" class="block mt-1 w-full" type="text" name="address"/>
                </div>
                <div class="mt-4 col-span-8">
                    <x-jet-label for="mobile-number" value="{{ __('Mobile Number') }}" />
                    <x-jet-input wire:model.defer="contact.mobile_number" id="mobile-number" class="block mt-1 w-full" type="text" name="mobile-number"/>
                </div>
            </div>
        </div>

        <div x-show="openTab == 3" x-cloak class="sm:px-6 lg:px-8 w-full">
            <div class="my-6 text-lg font-semibold">{{ $guardian->relationship ?? 'N/A' }}</div>
            <div class="grid grid-cols-8 gap-6">
                <div class="mt-4 col-span-4">
                    <x-jet-label for="firstname" value="{{ __('First Name') }}" />
                    <x-jet-input wire:model.defer="guardianPerson.firstname" id="firstname" class="block mt-1 w-full" type="text" name="firstname"/>
                </div>
                <div class="mt-4 col-span-4">
                    <x-jet-label for="middlname" value="{{ __('Middle Name') }}" />
                    <x-jet-input wire:model.defer="guardianPerson.middlename" id="year" class="block mt-1 w-full" type="text" name="middlname"/>
                </div>
                <div class="mt-4 col-span-4">
                    <x-jet-label for="lastname" value="{{ __('Last Name') }}" />
                    <x-jet-input wire:model.defer="guardianPerson.lastname" id="lastname" class="block mt-1 w-full" type="text" name="lastname"/>
                </div>
                <div class="mt-4 col-span-4">
                    <x-jet-label for="suffix" value="{{ __('Suffix') }}" />
                    <x-jet-input wire:model.defer="guardianPerson.suffix" id="year" class="block mt-1 w-full" type="text" name="suffix"/>
                </div>
            </div>
            <div class="my-6 text-lg font-semibold">Contacts</div>
            <div class="grid grid-cols-8 gap-6">
                <div class="mt-4 col-span-8">
                    <x-jet-label for="address" value="{{ __('Address') }}" />
                    <x-jet-input wire:model.defer="guardianContact.address" id="address" class="block mt-1 w-full" type="text" name="address"/>
                </div>
                <div class="mt-4 col-span-8">
                    <x-jet-label for="mobile-number" value="{{ __('Mobile Number') }}" />
                    <x-jet-input wire:model.defer="guardianContact.mobile_number" id="mobile-number" class="block mt-1 w-full" type="text" name="mobile-number"/>
                </div>
            </div>
        </div>

        <div x-show="openTab == 4" x-cloak class="sm:px-6 lg:px-8 w-full">
            <div class="my-6 text-lg font-semibold">Education</div>
            <div class="grid grid-cols-8 gap-6">
                <div class="mt-4 col-span-4">
                    <x-jet-label for="address" value="{{ __('School Name') }}" />
                    <x-jet-input wire:model.defer="education.name" id="address" class="block mt-1 w-full" type="text" name="address"/>
                </div>
                <div class="mt-4 col-span-4">
                    <x-jet-label for="mobile-number" value="{{ __('Date of Graduation') }}" />
                    <x-jet-input wire:model.defer="education.date_graduated" id="mobile-number" class="block mt-1 w-full" type="date" name="mobile-number"/>
                </div>
                <div class="mt-4 col-span-4">
                    <x-jet-label for="program" value="{{ __('Program / Track and Strand') }}" />
                    <x-jet-input wire:model.defer="education.program" id="program-number" class="block mt-1 w-full" type="text" name="program"/>
                </div>
                <div class="mt-4 col-span-4">
                    <x-jet-label for="school_type_id" value="{{ __('Type') }}" />
                    <x-jet-input wire:model.defer="education.school_type_id" id="school_type_id" class="block mt-1 w-full" type="text" name="school_type_id"/>
                </div>
                <div class="mt-4 col-span-4">
                    <x-jet-label for="level_id" value="{{ __('Level') }}" />
                    <x-jet-input wire:model.defer="education.level_id" id="level_id" class="block mt-1 w-full" type="text" name="level_id"/>
                </div>
            </div>
        </div>
    </div>
</div>
