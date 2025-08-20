<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <form action="{{ route('user.recharge') }}" method="post">
            @csrf
                <div class="p-6 text-gray-900">
                    <label>Select operator</label>
                    <div class="grid grid-cols-5 gap-4 mt-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="operator" value="bsnl" class="hidden peer">
                            <img src="{{ asset('uploads/logo/bsnl.png') }}" alt="bsnl Logo" 
                                class="w-full h-24 object-contain border-2 border-transparent rounded-lg peer-checked:border-indigo-500 p-2" />
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="operator" value="jio" class="hidden peer">
                            <img src="{{ asset('uploads/logo/jio.png') }}" alt="jio Logo" 
                                class="w-full h-24 object-contain border-2 border-transparent rounded-lg peer-checked:border-indigo-500 p-2" />
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="operator" value="idea" class="hidden peer">
                            <img src="{{ asset('uploads/logo/idea.png') }}" alt="idea Logo" 
                                class="w-full h-24 object-contain border-2 border-transparent rounded-lg peer-checked:border-indigo-500 p-2" />
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="operator" value="airtel" class="hidden peer">
                            <img src="{{ asset('uploads/logo/airtel.png') }}" alt="airtel Logo" 
                                class="w-full h-24 object-contain border-2 border-transparent rounded-lg peer-checked:border-indigo-500 p-2" />
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="operator" value="vodafone" class="hidden peer">
                            <img src="{{ asset('uploads/logo/vodafone.png') }}" alt="vodafone Logo" 
                                class="w-full h-24 object-contain border-2 border-transparent rounded-lg peer-checked:border-indigo-500 p-2" />
                        </label>
                    </div>

                    <div class="row mt-5">
                        <x-input-label for="contact_number" :value="__('Enter Prepaid Contact Number')" />
                        <x-text-input id="contact_number" class="block mt-1 w-full" type="text" name="contact_number" :value="old('contact_number')" required autocomplete="contact_number" onkeypress="return /[0-9]/i.test(event.key)" minlength="10" maxlength="10"  />
                        <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
                    </div>

                    <div class="flex gap-3 mt-3">
                        <div class="w-full">
                            <x-input-label for="recharge_amount" :value="__('Enter Recharge Amount')" />
                            <x-text-input id="recharge_amount" class="block mt-1 w-full" type="text" name="recharge_amount" :value="old('recharge_amount')" required autocomplete="recharge_amount" onkeypress="return /[0-9]/i.test(event.key)" minlength="1" maxlength="10"  />
                            <x-input-error :messages="$errors->get('recharge_amount')" class="mt-2" />
                        </div>
                        <button class="btn bg-slate-600 text-white mt-4 rounded-lg w-1/3">
                            Plan
                        </button>
                    </div>
                    <div class="flex justify-center mt-3">
                        <button type="submit" class="btn bg-slate-600 text-white mt-4 py-3 rounded-lg w-2/3">
                            Proceed To Recharge
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



</x-app-layout>
