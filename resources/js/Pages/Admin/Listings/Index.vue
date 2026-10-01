<script setup>
import { computed, reactive, watch } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'

const props = defineProps({
    listings: {
        type: Object,
        required: true,
    },
    cities: {
        type: Array,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
    filters: {
        type: Object,
        required: true,
    },
})

const filters = reactive({
    search: props.filters.search || '',
    city_id: props.filters.city_id || '',
    category_id: props.filters.category_id || '',
})

let searchTimer = null

const applyFilters = () => {
    router.get(
        route('admin.listings.index'),
        {
            search: filters.search || undefined,
            city_id: filters.city_id || undefined,
            category_id: filters.category_id || undefined,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    )
}

watch(
    () => filters.search,
    () => {
        clearTimeout(searchTimer)

        searchTimer = setTimeout(() => {
            applyFilters()
        }, 400)
    }
)

const clearFilters = () => {
    filters.search = ''
    filters.city_id = ''
    filters.category_id = ''

    router.get(
        route('admin.listings.index'),
        {},
        {
            preserveState: true,
            replace: true,
        }
    )
}

const visiblePages = computed(() => {
    return props.listings.links.filter(
        link => link.url !== null
    )
})

const formatDate = (date) => {
    if (!date) {
        return '-'
    }

    return new Date(date).toLocaleDateString()
}
</script>

<template>
    <Head title="Listings" />

    <div class="min-h-screen bg-gray-50">

        <!-- Header -->
        <header class="border-b bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">

                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        YP Nepal Listings
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Manage businesses in the YP Nepal directory
                    </p>
                </div>

                <Link
                    :href="route('dashboard')"
                    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    Dashboard
                </Link>

            </div>
        </header>

        <main class="mx-auto max-w-7xl px-6 py-8">

            <!-- Search / Filters -->
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

                <div class="grid gap-4 md:grid-cols-4">

                    <!-- Search -->
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Search
                        </label>

                        <input
                            v-model="filters.search"
                            type="text"
                            placeholder="Search business name, phone or email..."
                            class="w-full rounded-lg border-gray-300 px-4 py-2.5 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        />
                    </div>

                    <!-- City -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            City
                        </label>

                        <select
                            v-model="filters.city_id"
                            @change="applyFilters"
                            class="w-full rounded-lg border-gray-300 px-4 py-2.5 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="">
                                All cities
                            </option>

                            <option
                                v-for="city in cities"
                                :key="city.id"
                                :value="city.id"
                            >
                                {{ city.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">
                            Category
                        </label>

                        <select
                            v-model="filters.category_id"
                            @change="applyFilters"
                            class="w-full rounded-lg border-gray-300 px-4 py-2.5 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            <option value="">
                                All categories
                            </option>

                            <option
                                v-for="category in categories"
                                :key="category.id"
                                :value="category.id"
                            >
                                {{ category.name }}
                            </option>
                        </select>
                    </div>

                </div>

                <div class="mt-4 flex justify-end">
                    <button
                        @click="clearFilters"
                        class="rounded-lg px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100"
                    >
                        Clear filters
                    </button>
                </div>

            </div>

            <!-- Stats -->
            <div class="mt-6 grid gap-4 md:grid-cols-3">

                <div class="rounded-xl border bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">
                        Total Listings
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ listings.total.toLocaleString() }}
                    </p>
                </div>

                <div class="rounded-xl border bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">
                        Showing
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ listings.data.length }}
                    </p>
                </div>

                <div class="rounded-xl border bg-white p-5 shadow-sm">
                    <p class="text-sm text-gray-500">
                        Current Page
                    </p>

                    <p class="mt-2 text-3xl font-bold text-gray-900">
                        {{ listings.current_page }}
                    </p>
                </div>

            </div>

            <!-- Listings table -->
            <div class="mt-6 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">

                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Business
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    City
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Category
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Phone
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    ID
                                </th>
                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">

                            <tr
                                v-for="listing in listings.data"
                                :key="listing.id"
                                class="hover:bg-gray-50"
                            >

                                <td class="px-6 py-4">

                                    <div class="font-medium text-gray-900">
                                        {{ listing.name }}
                                    </div>

                                    <div class="mt-1 text-xs text-gray-500">
                                        {{ listing.add1 }}
                                    </div>

                                </td>

                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ listing.city?.name || '-' }}
                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex flex-wrap gap-1">

                                        <span
                                            v-for="category in listing.categories"
                                            :key="category.id"
                                            class="rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-medium text-indigo-700"
                                        >
                                            {{ category.name }}
                                        </span>

                                        <span
                                            v-if="listing.categories.length === 0"
                                            class="text-sm text-gray-400"
                                        >
                                            -
                                        </span>

                                    </div>

                                </td>

                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ listing.phone1 || '-' }}
                                </td>

                                <td class="px-6 py-4">

                                    <span
                                        :class="listing.status === 'A'
                                            ? 'bg-green-100 text-green-700'
                                            : 'bg-gray-100 text-gray-600'"
                                        class="rounded-full px-2.5 py-1 text-xs font-medium"
                                    >
                                        {{ listing.status === 'A' ? 'Active' : 'Disabled' }}
                                    </span>

                                </td>

                                <td class="px-6 py-4 text-right text-sm text-gray-500">
                                    #{{ listing.id }}
                                </td>

                            </tr>

                            <tr v-if="listings.data.length === 0">

                                <td
                                    colspan="6"
                                    class="px-6 py-12 text-center"
                                >
                                    <p class="text-sm font-medium text-gray-900">
                                        No listings found
                                    </p>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Try changing your search or filters.
                                    </p>
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

                <!-- Pagination -->
                <div
                    v-if="listings.last_page > 1"
                    class="flex flex-wrap items-center justify-center gap-2 border-t bg-gray-50 px-6 py-4"
                >

                    <Link
                        v-for="link in visiblePages"
                        :key="link.label"
                        :href="link.url || '#'"
                        v-html="link.label"
                        class="rounded-lg border px-3 py-2 text-sm"
                        :class="link.active
                            ? 'border-indigo-600 bg-indigo-600 text-white'
                            : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-100'"
                    />

                </div>

            </div>

        </main>

    </div>
</template>