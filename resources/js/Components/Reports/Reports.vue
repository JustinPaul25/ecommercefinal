<template>
<div class="grid gap-16 pt-12 lg:grid-cols-3 lg:gap-x-5 lg:gap-y-12 mb-4">
      <div>
        <div class="relative border border-gray-300 rounded-md px-3 py-2 shadow-sm focus-within:ring-1 focus-within:ring-orange-600 focus-within:border-orange-600">
            <label for="name" class="absolute -top-2 left-2 -mt-px inline-block px-1 bg-white text-xs font-medium text-gray-900">Filter By Year</label>
            <input type="text" name="name" id="name" class="block w-full border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0 sm:text-sm" placeholder="Jane Doe">
        </div>
      </div>

      <div>
        <div class="relative border border-gray-300 rounded-md px-3 py-2 shadow-sm focus-within:ring-1 focus-within:ring-orange-600 focus-within:border-orange-600">
            <label for="name" class="absolute -top-2 left-2 -mt-px inline-block px-1 bg-white text-xs font-medium text-gray-900">Filter By Month</label>
            <input type="text" name="name" id="name" class="block w-full border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0 sm:text-sm" placeholder="Jane Doe">
        </div>
      </div>

      <div>
        <div class="relative border border-gray-300 rounded-md px-3 py-2 shadow-sm focus-within:ring-1 focus-within:ring-orange-600 focus-within:border-orange-600">
            <label for="name" class="absolute -top-2 left-2 -mt-px inline-block px-1 bg-white text-xs font-medium text-gray-900">Filter By day</label>
            <input type="text" name="name" id="name" class="block w-full border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0 sm:text-sm" placeholder="Jane Doe">
        </div>
      </div>
    </div>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Edit</span>
                    </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Odd row -->
                    <tr class="bg-white">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Jane Cooper</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Regional Paradigm Technician</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">jane.cooper@example.com</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Admin</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="#" class="text-orange-600 hover:text-orange-900">Edit</a>
                    </td>
                    </tr>

                    <!-- Even row -->
                    <tr class="bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Cody Fisher</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Product Directives Officer</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">cody.fisher@example.com</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Owner</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="#" class="text-orange-600 hover:text-orange-900">Edit</a>
                    </td>
                    </tr>

                    <!-- More people... -->
                </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {

        }
    }
}
</script>