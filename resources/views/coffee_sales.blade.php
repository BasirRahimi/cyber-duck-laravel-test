<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New ☕️ Sales') }}
        </h2>
    </x-slot>

    <div x-data="{ sales: {{$sales}} }">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-gray-700 font-bold text-xl mb-3">Price calculator</h3>
                        <form 
                            class="grid md:grid-cols-4 gap-8" 
                            x-data="{ quantity: null, unitCost: null, productId: 1, sellingPrice: null }" 
                            x-effect="quantity && unitCost ? sellingPrice = await getSellingPrice(quantity, unitCost, productId) : sellingPrice = null" 
                            @submit.prevent="sales = [await recordSale($data), ...sales]; quantity = unitCost = sellingPrice = null;"
                            >
                            <label class="block">
                                <span class="text-gray-700">Quantity</span>
                                <input 
                                    type="number" 
                                    min="1" 
                                    x-model.debounce.500ms="quantity" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                    x-bind:class="quantity === '0' ? 'border-red-500 focus:border-red-500 focus:ring-red-300' : ''" placeholder=""
                                    >
                            </label>

                            <label class="block">
                                <span class="text-gray-700">Unit Cost (£)</span>
                                <input 
                                    type="number" 
                                    step="0.01" 
                                    min="0.00" 
                                    x-model.debounce.500ms="unitCost" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                    placeholder=""
                                    >
                            </label>

                            <div>
                                <span class="text-gray-700">Selling Price</span>
                                <p class="py-2 border border-transparent" x-html="sellingPrice"></p>
                            </div>

                            <button 
                                type="submit" 
                                x-bind:disabled="!sellingPrice" 
                                class="self-center rounded-md bg-indigo-600 px-3 py-2 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                >
                                Record Sale
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-gray-700 font-bold text-xl mb-3">Previous Sales</h3>

                        <div class="relative overflow-x-auto rounded-md">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                <thead class="text-xs text-white uppercase bg-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Quantity
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Unit Cost
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Selling Price
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="sale in sales">
                                        <tr class="odd:bg-white even:bg-gray-50 border-b">
                                            <td class="px-6 py-4" x-html="sale.quantity">
                                            </td>
                                            <td class="px-6 py-4" x-html="sale.unit_cost">
                                            </td>
                                            <td class="px-6 py-4" x-html="sale.selling_price">
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>