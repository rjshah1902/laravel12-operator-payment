<style>
    
<style>
    .table-container {
        width: 100%;
        overflow-x: auto;
        margin-top: 16px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        font-family: Arial, sans-serif;
        font-size: 14px;
    }

    .custom-table thead {
        background-color: #f8f9fa;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .custom-table th,
    .custom-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #e2e2e2;
        vertical-align: top;
    }

    .custom-table th {
        font-weight: 600;
        font-size: 13px;
        color: #333;
    }

    .custom-table tbody tr:hover {
        background-color: #f4f6f8;
    }

    .custom-table pre {
        white-space: pre-wrap;
        word-wrap: break-word;
        background: #f8f8f8;
        padding: 8px;
        border-radius: 4px;
        font-size: 12px;
        /* max-height: 150px; */
        overflow-y: auto;
    }

    .status {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status.success {
        background-color: #d4edda;
        color: #155724;
    }

    .status.error {
        background-color: #f8d7da;
        color: #721c24;
    }

    .empty {
        text-align: center;
        padding: 20px;
        color: #777;
    }
</style>

</style>

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
                            <input type="radio" name="operator" required value="bsnl" class="hidden peer">
                            <img src="{{ asset('uploads/logo/bsnl.png') }}" alt="bsnl Logo" 
                                class="w-full h-24 object-contain border-2 border-transparent rounded-lg peer-checked:border-indigo-500 p-2" />
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="operator" required value="jio" class="hidden peer">
                            <img src="{{ asset('uploads/logo/jio.png') }}" alt="jio Logo" 
                                class="w-full h-24 object-contain border-2 border-transparent rounded-lg peer-checked:border-indigo-500 p-2" />
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="operator" required value="idea" class="hidden peer">
                            <img src="{{ asset('uploads/logo/idea.png') }}" alt="idea Logo" 
                                class="w-full h-24 object-contain border-2 border-transparent rounded-lg peer-checked:border-indigo-500 p-2" />
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="operator" required value="airtel" class="hidden peer">
                            <img src="{{ asset('uploads/logo/airtel.png') }}" alt="airtel Logo" 
                                class="w-full h-24 object-contain border-2 border-transparent rounded-lg peer-checked:border-indigo-500 p-2" />
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="operator" required value="vodafone" class="hidden peer">
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

        
        <div class="table-container mt-5">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Operator</th>
                        <th>Contact</th>
                        <th>Amount</th>
                        <th>Response Body</th>
                        <th>Payment Status</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($apiLogs as $index => $log)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ Str::ucfirst($log->recharge->operator) }}</td>
                            <td>{{ $log->recharge->contact_number }}</td>
                            <td>{{ $log->recharge->recharge_amount }}</td>
                            <td>
                                <pre>{{ json_encode(json_decode($log->response_body), JSON_PRETTY_PRINT) }}</pre>
                            </td>
                            <td>
                                <span class="status {{ $log->recharge->payment_status == 'paid' ? 'success' : 'error' }}">
                                    {{ ucfirst($log->recharge->payment_status) }}
                                </span>
                            </td>
                            <td>{{ $log->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty">No API logs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>



</x-app-layout>
