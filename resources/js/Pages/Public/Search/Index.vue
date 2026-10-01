<script setup>
import { Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    query: {
        type: String,
        default: '',
    },
    listings: {
        type: Object,
        required: true,
    },
})

const search = ref(props.query)

function submitSearch() {
    router.get('/search', {
        q: search.value,
    })
}

function cleanDescription(description) {
    if (!description) {
        return ''
    }

    const temp = document.createElement('div')
    temp.innerHTML = description

    return temp.textContent
        .replace(/\s+/g, ' ')
        .trim()
}
</script>

<template>
    <div class="page">

        <!-- Header -->
        <header class="site-header">
            <div class="container header-inner">

                <Link href="/" class="brand">
                    <span class="brand-mark">YP</span>

                    <span>
                        <strong>YP Nepal</strong>
                        <small>Nepal Business Directory</small>
                    </span>
                </Link>

                <nav>
                    <Link href="/">Home</Link>
                    <Link href="/categories">Categories</Link>
                    <Link href="/locations">Locations</Link>
                    <Link href="/listings?featured=1">Featured</Link>
                    <Link href="/map">Map</Link>
                    <Link href="/login">Login</Link>
                </nav>

            </div>
        </header>

        <!-- Main -->
        <main class="container main">

            <div class="page-heading">
                <span class="eyebrow">YP NEPAL SEARCH</span>

                <h1>
                    Search businesses
                </h1>

                <p>
                    Find businesses, categories and locations across Nepal.
                </p>
            </div>

            <!-- Search -->
            <form class="search-box" @submit.prevent="submitSearch">

                <input
                    v-model="search"
                    type="text"
                    placeholder="Search businesses, categories or locations..."
                >

                <button type="submit">
                    Search
                </button>

            </form>

            <!-- Results -->
            <section class="results">

                <div class="results-header">
                    <div>
                        <h2>
                            Search results
                        </h2>

                        <p v-if="query">
                            Results for:
                            <strong>"{{ query }}"</strong>
                        </p>

                        <p v-else>
                            Enter a search term to find businesses.
                        </p>
                    </div>

                    <span v-if="listings.total !== undefined">
                        {{ listings.total }} results
                    </span>
                </div>

                <!-- No results -->
                <div
                    v-if="query && listings.data.length === 0"
                    class="empty"
                >
                    <h3>No businesses found</h3>

                    <p>
                        Try another business name, category or location.
                    </p>
                </div>

                <!-- Listing cards -->
                <div
                    v-else
                    class="listing-grid"
                >

                    <article
                        v-for="listing in listings.data"
                        :key="listing.id"
                        class="listing-card"
                    >

                        <div class="card-content">

                            <span class="listing-category">
                                {{ listing.categories?.[0]?.name || 'Business' }}
                            </span>

                            <h3>
                                <Link :href="`/listing/${listing.id}`">
                                    {{ listing.name }}
                                </Link>
                            </h3>

                            <p class="location">
                                {{ listing.city?.name || 'Nepal' }}
                            </p>

                            <p
                                v-if="listing.description"
                                class="description"
                            >
                                {{ cleanDescription(listing.description) }}
                            </p>

                            <div class="contact">
                                <span v-if="listing.phone1">
                                    {{ listing.phone1 }}
                                </span>

                                <span v-if="listing.add1">
                                    {{ listing.add1 }}
                                </span>
                            </div>

                        </div>

                    </article>

                </div>

                <!-- Pagination -->
                <div
                    v-if="listings.links?.length > 3"
                    class="pagination"
                >

                    <template
                        v-for="link in listings.links"
                        :key="link.label"
                    >
                        <Link
                            v-if="link.url"
                            :href="link.url"
                            class="page-link"
                            :class="{ active: link.active }"
                            v-html="link.label"
                        />

                        <span
                            v-else
                            class="page-link disabled"
                            v-html="link.label"
                        />
                    </template>

                </div>

            </section>

        </main>

        <!-- Footer -->
        <footer class="footer">
            <div class="container footer-inner">

                <div>
                    <strong>YP Nepal</strong>
                    <p>
                        Nepal Business Directory
                    </p>
                </div>

                <div class="footer-links">
                    <Link href="/categories">Categories</Link>
                    <Link href="/locations">Locations</Link>
                    <Link href="/about">About</Link>
                    <Link href="/contact">Contact</Link>
                </div>

            </div>
        </footer>

    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

.page {
    min-height: 100vh;
    background: #fbfaf8;
    color: #16202d;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.container {
    width: min(1180px, calc(100% - 40px));
    margin: auto;
}

.site-header {
    background: white;
    border-bottom: 1px solid #e6e2da;
}

.header-inner {
    min-height: 78px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 30px;
}

.brand {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #16202d;
    text-decoration: none;
}

.brand-mark {
    width: 42px;
    height: 42px;
    display: grid;
    place-items: center;
    background: #c08a2e;
    color: white;
    font-weight: 700;
    border-radius: 10px;
}

.brand strong {
    display: block;
}

.brand small {
    display: block;
    color: #5a6673;
    font-size: 11px;
    margin-top: 2px;
}

nav {
    display: flex;
    gap: 22px;
}

nav a {
    color: #5a6673;
    text-decoration: none;
    font-size: 14px;
}

nav a:hover {
    color: #c08a2e;
}

.main {
    padding: 70px 0 100px;
}

.page-heading {
    margin-bottom: 30px;
}

.eyebrow {
    color: #c08a2e;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1.5px;
}

h1 {
    margin: 10px 0;
    font-size: 42px;
}

.page-heading p {
    color: #5a6673;
}

.search-box {
    display: flex;
    background: white;
    padding: 8px;
    border: 1px solid #e6e2da;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(22, 32, 45, .06);
    margin-bottom: 55px;
}

.search-box input {
    flex: 1;
    border: 0;
    outline: none;
    padding: 15px;
    font-size: 15px;
    font-family: inherit;
}

.search-box button {
    border: 0;
    background: #c08a2e;
    color: white;
    padding: 0 28px;
    border-radius: 9px;
    cursor: pointer;
    font-weight: 600;
}

.results-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.results-header h2 {
    margin: 0 0 5px;
}

.results-header p {
    color: #5a6673;
    margin: 0;
}

.listing-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.listing-card {
    background: white;
    border: 1px solid #e6e2da;
    border-radius: 14px;
    padding: 25px;
}

.listing-category {
    color: #c08a2e;
    font-size: 12px;
    font-weight: 700;
}

.listing-card h3 {
    margin: 10px 0;
}

.listing-card h3 a {
    color: #16202d;
    text-decoration: none;
}

.location {
    color: #5a6673;
    margin: 0 0 12px;
}

.description {
    color: #5a6673;
    font-size: 14px;
    line-height: 1.6;
}

.contact {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    color: #5a6673;
    font-size: 13px;
    margin-top: 15px;
}

.empty {
    background: white;
    border: 1px solid #e6e2da;
    border-radius: 14px;
    padding: 50px;
    text-align: center;
}

.empty p {
    color: #5a6673;
}

.pagination {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    margin-top: 35px;
}

.page-link {
    padding: 8px 13px;
    border: 1px solid #e6e2da;
    border-radius: 7px;
    background: white;
    color: #16202d;
    text-decoration: none;
    font-size: 13px;
}

.page-link.active {
    background: #c08a2e;
    color: white;
    border-color: #c08a2e;
}

.page-link.disabled {
    opacity: .5;
}

.footer {
    border-top: 1px solid #e6e2da;
    background: white;
    padding: 35px 0;
}

.footer-inner {
    display: flex;
    justify-content: space-between;
}

.footer p {
    color: #5a6673;
    margin: 5px 0;
}

.footer-links {
    display: flex;
    gap: 20px;
}

.footer-links a {
    color: #5a6673;
    text-decoration: none;
}

@media (max-width: 800px) {
    .header-inner {
        flex-direction: column;
        padding: 20px 0;
    }

    nav {
        flex-wrap: wrap;
        justify-content: center;
    }

    .listing-grid {
        grid-template-columns: 1fr;
    }

    .search-box {
        flex-direction: column;
        gap: 8px;
    }

    .search-box button {
        height: 48px;
    }

    .footer-inner {
        flex-direction: column;
        gap: 20px;
    }
}
</style>