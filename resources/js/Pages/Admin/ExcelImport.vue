<script setup>
import { computed, ref } from 'vue'
import { Head, useForm, usePage } from '@inertiajs/vue3'

const page = usePage()

const fileInput = ref(null)

const form = useForm({
    file: null,
})

const result = computed(() => {
    return page.props.flash?.import_result ?? null
})

const chooseFile = () => {
    fileInput.value?.click()
}

const handleFile = (event) => {
    const file = event.target.files[0]

    if (!file) {
        return
    }

    form.file = file
}

const upload = () => {

    if (!form.file) {
        return
    }

    form.post(route('admin.excel-import.store'), {
        forceFormData: true,

        onSuccess: () => {
            if (fileInput.value) {
                fileInput.value.value = ''
            }

            form.reset('file')
        },
    })
}
</script>

<template>

    <Head title="Import Excel" />

    <div class="min-h-screen bg-gray-100">

        <!-- Header -->

        <header class="bg-white shadow">

            <div
                class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4"
            >

                <div>
                    <h1 class="text-xl font-semibold text-gray-800">
                        YP Nepal Admin
                    </h1>

                    <p class="text-sm text-gray-500">
                        Import business listings
                    </p>
                </div>

                <a
                    :href="route('dashboard')"
                    class="rounded bg-gray-800 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700"
                >
                    Dashboard
                </a>

            </div>

        </header>


        <!-- Main -->

        <main class="mx-auto max-w-7xl px-6 py-8">

            <div class="rounded-lg bg-white p-6 shadow">

                <h2 class="text-lg font-semibold text-gray-800">
                    Upload Excel File
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Upload an Excel file containing YP Nepal business listings.
                </p>


                <!-- Excel format -->

                <div class="mt-6 rounded-md bg-blue-50 p-4">

                    <h3 class="font-medium text-blue-900">
                        Excel columns
                    </h3>

                    <p class="mt-2 text-sm text-blue-800">
                        Your Excel file must contain these columns:
                    </p>

                    <div class="mt-3 flex flex-wrap gap-2">

                        <span
                            v-for="column in [
                                'name',
                                'city',
                                'address',
                                'address2',
                                'email',
                                'po_box',
                                'phone',
                                'phone2',
                                'fax',
                                'website',
                                'description',
                                'contact_person',
                                'category',
                                'latitude',
                                'longitude'
                            ]"
                            :key="column"
                            class="rounded bg-white px-2 py-1 text-xs text-gray-700 shadow-sm"
                        >
                            {{ column }}
                        </span>

                    </div>

                </div>


                <!-- File -->

                <div class="mt-6">

                    <label
                        class="block text-sm font-medium text-gray-700"
                    >
                        Excel file
                    </label>

                    <input
                        ref="fileInput"
                        type="file"
                        accept=".xlsx,.xls"
                        class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm"
                        @change="handleFile"
                    />

                    <p class="mt-2 text-xs text-gray-500">
                        Supported files: .xlsx and .xls. Maximum size: 10 MB.
                    </p>

                </div>


                <!-- Validation error -->

                <div
                    v-if="form.errors.file"
                    class="mt-4 rounded-md bg-red-50 p-4 text-sm text-red-700"
                >
                    {{ form.errors.file }}
                </div>


                <!-- Upload button -->

                <div class="mt-6">

                    <button
                        type="button"
                        :disabled="form.processing || !form.file"
                        class="rounded-md bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                        @click="upload"
                    >
                        {{
                            form.processing
                                ? 'Importing...'
                                : 'Upload and Import'
                        }}
                    </button>

                </div>

            </div>


            <!-- Results -->

            <div
                v-if="result"
                class="mt-6 rounded-lg bg-white p-6 shadow"
            >

                <h2 class="text-lg font-semibold text-gray-800">
                    Import Result
                </h2>


                <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-4">

                    <div class="rounded-lg bg-gray-50 p-4">
                        <div class="text-sm text-gray-500">
                            Total rows
                        </div>

                        <div class="mt-1 text-2xl font-bold">
                            {{ result.total }}
                        </div>
                    </div>


                    <div class="rounded-lg bg-green-50 p-4">
                        <div class="text-sm text-green-700">
                            Imported
                        </div>

                        <div class="mt-1 text-2xl font-bold text-green-700">
                            {{ result.imported }}
                        </div>
                    </div>


                    <div class="rounded-lg bg-yellow-50 p-4">
                        <div class="text-sm text-yellow-700">
                            Duplicates
                        </div>

                        <div class="mt-1 text-2xl font-bold text-yellow-700">
                            {{ result.duplicates }}
                        </div>
                    </div>


                    <div class="rounded-lg bg-red-50 p-4">
                        <div class="text-sm text-red-700">
                            Invalid / failed
                        </div>

                        <div class="mt-1 text-2xl font-bold text-red-700">
                            {{ result.invalid }}
                        </div>
                    </div>

                </div>


                <!-- Errors -->

                <div
                    v-if="result.errors?.length"
                    class="mt-8"
                >

                    <h3 class="font-semibold text-red-700">
                        Rows that were not imported
                    </h3>

                    <div class="mt-3 overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">

                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">
                                        Row
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">
                                        Name
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">
                                        Reason
                                    </th>
                                </tr>

                            </thead>

                            <tbody class="divide-y divide-gray-200 bg-white">

                                <tr
                                    v-for="error in result.errors"
                                    :key="`${error.row}-${error.reason}`"
                                >

                                    <td class="px-4 py-3 text-sm">
                                        {{ error.row }}
                                    </td>

                                    <td class="px-4 py-3 text-sm">
                                        {{ error.name || '-' }}
                                    </td>

                                    <td class="px-4 py-3 text-sm text-red-600">
                                        {{ error.reason }}
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>


                <!-- Duplicates -->

                <div
                    v-if="result.duplicate_rows?.length"
                    class="mt-8"
                >

                    <h3 class="font-semibold text-yellow-700">
                        Duplicate rows
                    </h3>

                    <div class="mt-3 overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">

                                <tr>

                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">
                                        Row
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">
                                        Name
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">
                                        Reason
                                    </th>

                                </tr>

                            </thead>

                            <tbody class="divide-y divide-gray-200">

                                <tr
                                    v-for="duplicate in result.duplicate_rows"
                                    :key="duplicate.row"
                                >

                                    <td class="px-4 py-3 text-sm">
                                        {{ duplicate.row }}
                                    </td>

                                    <td class="px-4 py-3 text-sm">
                                        {{ duplicate.name }}
                                    </td>

                                    <td class="px-4 py-3 text-sm text-yellow-700">
                                        {{ duplicate.reason }}
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </main>

    </div>

</template>