<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'

defineProps({
    featuredListings: {
        type: Array,
        default: () => [],
    },
    categories: {
        type: Array,
        default: () => [],
    },
    cities: {
        type: Array,
        default: () => [],
    },
})

const aiQuery = ref('')
const aiLoading = ref(false)

function aiSearch() {
    if (!aiQuery.value.trim()) return
    aiLoading.value = true

    router.post('/ai-search', { q: aiQuery.value }, {
        preserveScroll: true,
        onFinish: () => (aiLoading.value = false),
    })
}
</script>

<template>
    <div class="yp-page">

        <!-- TOP STRIP -->
        <div class="strip">
            <div class="wrap strip-inner">
                <div>
                    Need urgent help?
                    <a href="/emergency">View emergency numbers</a>
                </div>

                <div>
                    <a href="/add-listing">List your business</a>
                </div>
            </div>
        </div>

        <!-- HEADER -->
        <header>
            <div class="wrap nav">

                <Link href="/" class="brand">
                    <svg
                        class="mark"
                        viewBox="0 0 40 40"
                        aria-hidden="true"
                    >
                        <path
                            d="M20 3c-7 0-12.5 5.4-12.5 12.1C7.5 24.4 20 37 20 37s12.5-12.6 12.5-21.9C32.5 8.4 27 3 20 3z"
                            fill="#C08A2E"
                        />

                        <circle
                            cx="20"
                            cy="15"
                            r="5.4"
                            fill="#fff"
                        />
                    </svg>

                    <span>
                        <b>YP<span>Nepal</span></b>
                        <small>Nepal Business Directory</small>
                    </span>
                </Link>

                <nav class="menu">
                    <Link href="/categories">
                        Categories
                    </Link>

                    <Link href="/locations">
                        Locations
                    </Link>

                    <Link href="/listings?featured=1">
                        Featured
                    </Link>

                    <Link href="/map">
                        Map
                    </Link>
                </nav>

                <a href="/login" class="login">
                    Member Login
                </a>

            </div>
        </header>

        <!-- HERO -->
        <section class="hero">

            <div class="mountains"></div>

            <div class="shade"></div>

            <div class="wrap hero-content">

                <h1>
                    Find trusted businesses across Nepal
                </h1>

                <p>
                    Search 45,000+ companies, services and brands
                    listed across Nepal.
                </p>

                <!-- SEARCH -->
                <form
                    class="search"
                    action="/search"
                    method="get"
                >

                    <div class="search-field">

                        <svg
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.2"
                        >
                            <circle
                                cx="11"
                                cy="11"
                                r="7"
                            />

                            <path d="m20 20-3.2-3.2" />
                        </svg>

                        <input
                            type="text"
                            name="q"
                            placeholder="What are you looking for?"
                        />

                    </div>

                    <div class="search-field">

                        <svg
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.2"
                        >
                            <path
                                d="M12 21s7-6.2 7-11a7 7 0 1 0-14 0c0 4.8 7 11 7 11z"
                            />

                            <circle
                                cx="12"
                                cy="10"
                                r="2"
                            />
                        </svg>

                        <input
                            type="text"
                            name="city"
                            placeholder="Kathmandu, Pokhara, Lalitpur..."
                        />

                    </div>

                    <button type="submit">
                        Search
                    </button>

                </form>

                <form class="search ai-search" @submit.prevent="aiSearch">
                <div class="search-field">

                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C08A2E" stroke-width="2.2">
                        <path d="M12 3v3M12 18v3M3 12h3M18 12h3M5.6 5.6l2.1 2.1M16.3 16.3l2.1 2.1M5.6 18.4l2.1-2.1M16.3 7.7l2.1-2.1"/>
                        <circle cx="12" cy="12" r="3.5"/>
                    </svg>

                    <input
                        v-model="aiQuery"
                        type="text"
                        placeholder='Try "plumber in Kathmandu"…'
                    />
                </div>

                <button type="submit" :disabled="aiLoading">
                    {{ aiLoading ? 'Thinking…' : 'AI Search' }}
                </button>
            </form>

            </div>
        </section>

        <!-- CATEGORIES -->
        <section class="section">

            <div class="wrap">

                <div class="section-heading">

                    <div>
                        <h2>Browse categories</h2>

                        <p>
                            Explore businesses and services by category.
                        </p>
                    </div>

                    <Link
                        href="/categories"
                        class="more"
                    >
                        View all categories
                    </Link>

                </div>

                <div class="category-grid">

                    <Link
                        v-for="category in categories"
                        :key="category.id"
                        :href="`/category/${category.id}`"
                        class="category-card"
                    >

                        <div class="category-icon">
                            →
                        </div>

                        <div>
                            <strong>
                                {{ category.name }}
                            </strong>

                            <span>
                                {{ category.listings_count }}
                                listings
                            </span>
                        </div>

                    </Link>

                </div>

            </div>

        </section>

        <!-- FEATURED BUSINESSES -->
        <section class="section featured">

            <div class="wrap">

                <div class="section-heading">

                    <div>
                        <h2>Featured businesses</h2>

                        <p>
                            Businesses with an active featured listing.
                        </p>
                    </div>

                    <Link
                        href="/listings?featured=1"
                        class="more"
                    >
                        View all businesses
                    </Link>

                </div>

                <div class="business-grid">

                    <article
                        v-for="listing in featuredListings"
                        :key="listing.id"
                        class="business-card"
                    >

                        <div class="business-top">

                            <div class="business-logo">
                                <img
                                    v-if="listing.logo"
                                    :src="`/uploads/listings/${listing.logo}`"
                                    :alt="listing.name"
                                />

                                <span v-else>
                                    YP
                                </span>
                            </div>

                            <div>

                                <h3>
                                    <Link
                                        :href="`/listing/${listing.id}`"
                                    >
                                        {{ listing.name }}
                                    </Link>
                                </h3>

                                <div
                                    v-if="listing.categories?.length"
                                    class="category-name"
                                >
                                    {{ listing.categories[0].name }}
                                </div>

                            </div>

                        </div>

                        <div class="business-info">

                            <div v-if="listing.city">
                                📍
                                {{ listing.city.name }}

                                <span v-if="listing.add1">
                                    · {{ listing.add1 }}
                                </span>
                            </div>

                            <div v-if="listing.phone1">
                                ☎
                                {{ listing.phone1 }}
                            </div>

                        </div>

                        <div
                            v-if="listing.description"
                            class="listing-description"
                            v-html="listing.description"
                        ></div>

                    </article>

                </div>

            </div>

        </section>

        <!-- CITIES -->
        <section class="section cities">

            <div class="wrap">

                <div class="section-heading">

                    <div>
                        <h2>Explore by location</h2>

                        <p>
                            Find businesses in cities across Nepal.
                        </p>
                    </div>

                    <Link
                        href="/locations"
                        class="more"
                    >
                        View all locations
                    </Link>

                </div>

                <div class="city-grid">

                    <Link
                        v-for="city in cities"
                        :key="city.id"
                        :href="`/city/${city.id}`"
                        class="city-card"
                    >
                        <strong>
                            {{ city.name }}
                        </strong>

                        <span>
                            {{ city.listings_count }}
                            businesses
                        </span>
                    </Link>

                </div>

            </div>

        </section>

        <!-- BUSINESS CTA -->
        <section class="business-cta">

            <div class="wrap cta-inner">

                <div>
                    <h2>
                        Is your business listed on YP Nepal?
                    </h2>

                    <p>
                        Add your business and help customers
                        discover your services.
                    </p>
                </div>

                <a
                    href="/add-listing"
                    class="cta-button"
                >
                    List your business
                </a>

            </div>

        </section>

        <!-- FOOTER -->
        <footer>

            <div class="wrap footer-grid">

                <div>

                    <Link href="/" class="brand">

                        <svg
                            class="mark"
                            viewBox="0 0 40 40"
                        >
                            <path
                                d="M20 3c-7 0-12.5 5.4-12.5 12.1C7.5 24.4 20 37 20 37s12.5-12.6 12.5-21.9C32.5 8.4 27 3 20 3z"
                                fill="#C08A2E"
                            />

                            <circle
                                cx="20"
                                cy="15"
                                r="5.4"
                                fill="#fff"
                            />
                        </svg>

                        <span>
                            <b>YP<span>Nepal</span></b>
                            <small>Nepal Business Directory</small>
                        </span>

                    </Link>

                    <p>
                        The online version of Global-Biz Yellow Pages.
                        Business information from across Nepal.
                    </p>

                </div>

                <div>
                    <h4>Browse</h4>

                    <Link href="/categories">
                        All categories
                    </Link>

                    <Link href="/locations">
                        Districts
                    </Link>

                    <Link href="/listings?featured=1">
                        Featured businesses
                    </Link>
                </div>

                <div>
                    <h4>Top locations</h4>

                    <Link
                        v-for="city in cities.slice(0, 5)"
                        :key="city.id"
                        :href="`/city/${city.id}`"
                    >
                        {{ city.name }}
                    </Link>
                </div>

                <div>
                    <h4>For businesses</h4>

                    <a href="/add-listing">
                        Add your business
                    </a>

                    <a href="/advertise">
                        Advertising
                    </a>

                    <a href="/contact">
                        Contact us
                    </a>
                </div>

            </div>

            <div class="wrap copyright">
                © {{ new Date().getFullYear() }} YP Nepal
            </div>

        </footer>

    </div>
</template>

<style scoped>

.ai-search {
    grid-template-columns: 1fr auto;
    margin-top: 10px;
    background: #FFFDF7;
    border: 1.5px solid #E8D5AE;
}

.ai-search button:disabled {
    opacity: .7;
}
:global(*) {
    box-sizing: border-box;
}

:global(body) {
    margin: 0;
    background: #FBFAF8;
    color: #16202D;
    font-family:
        'Plus Jakarta Sans',
        system-ui,
        -apple-system,
        BlinkMacSystemFont,
        "Segoe UI",
        sans-serif;
}

:global(a) {
    text-decoration: none;
    color: inherit;
}

.yp-page {
    min-height: 100vh;
}

.wrap {
    width: min(1180px, calc(100% - 40px));
    margin: auto;
}

.strip {
    background: #16202D;
    color: #D9E0E8;
    font-size: 13px;
}

.strip-inner {
    min-height: 38px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
}

.strip a {
    color: #F0D8A8;
    font-weight: 700;
}

header {
    background: white;
    border-bottom: 1px solid #E6E2DA;
    position: sticky;
    top: 0;
    z-index: 40;
}

.nav {
    min-height: 74px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 25px;
}

.brand {
    display: flex;
    align-items: center;
    gap: 10px;
}

.brand .mark {
    width: 34px;
    height: 34px;
}

.brand b {
    display: block;
    font-size: 21px;
    font-weight: 800;
    line-height: 1.1;
}

.brand b span {
    color: #C08A2E;
}

.brand small {
    display: block;
    font-size: 11px;
    color: #5A6673;
}

.menu {
    display: flex;
    gap: 28px;
    font-size: 14px;
    font-weight: 600;
    color: #3D4956;
}

.menu a:hover {
    color: #C08A2E;
}

.login {
    border: 1.5px solid #C08A2E;
    color: #C08A2E;
    padding: 9px 20px;
    border-radius: 999px;
    font-weight: 700;
}

.hero {
    position: relative;
    min-height: 420px;
    display: flex;
    align-items: center;
    overflow: hidden;
    color: white;
    background:
        linear-gradient(
            135deg,
            #F0C377,
            #C98F4A 45%,
            #43342A
        );
}

.mountains {
    position: absolute;
    inset: 0;
    opacity: .85;
    background:
        linear-gradient(
            135deg,
            transparent 35%,
            rgba(255,255,255,.25) 35.2%,
            transparent 55%
        );
}

.shade {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        90deg,
        rgba(22,32,45,.65),
        rgba(22,32,45,.15)
    );
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero h1 {
    max-width: 720px;
    margin: 0 0 15px;
    font-size: clamp(34px, 5vw, 54px);
    line-height: 1.08;
    letter-spacing: -1.5px;
}

.hero p {
    max-width: 700px;
    font-size: 17px;
    margin: 0 0 28px;
}

.search {
    max-width: 920px;
    display: grid;
    grid-template-columns: 1fr 1fr auto;
    background: white;
    padding: 7px;
    border-radius: 12px;
    box-shadow: 0 15px 45px rgba(0,0,0,.2);
}

.search-field {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 13px 15px;
    color: #6A7480;
}

.search-field + .search-field {
    border-left: 1px solid #E6E2DA;
}

.search-field input {
    width: 100%;
    border: 0;
    outline: 0;
    font: inherit;
    color: #16202D;
}

.search button {
    border: 0;
    background: #C08A2E;
    color: white;
    border-radius: 8px;
    padding: 0 30px;
    font-weight: 800;
    cursor: pointer;
}

.section {
    padding: 70px 0;
}

.section-heading {
    display: flex;
    justify-content: space-between;
    align-items: end;
    gap: 20px;
    margin-bottom: 28px;
}

.section-heading h2 {
    margin: 0 0 7px;
    font-size: 28px;
}

.section-heading p {
    margin: 0;
    color: #5A6673;
}

.more {
    color: #C08A2E;
    font-weight: 700;
    white-space: nowrap;
}

.category-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
}

.category-card {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: white;
    border: 1px solid #E6E2DA;
    border-radius: 12px;
    transition: .2s;
}

.category-card:hover,
.business-card:hover,
.city-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(22,32,45,.08);
}

.category-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: grid;
    place-items: center;
    background: #FBF6EC;
    color: #C08A2E;
    font-size: 20px;
}

.category-card strong,
.category-card span {
    display: block;
}
.listing-description {
    color: #5a6673;
    font-size: 14px;
    line-height: 1.6;
    margin-top: 12px;
}

.listing-description :deep(p) {
    margin: 0;
}

.listing-description :deep(span) {
    font-family: inherit !important;
    font-size: inherit !important;
    color: inherit !important;
    background: transparent !important;
}

.listing-description :deep(a) {
    color: #c08a2e;
}

.category-card span,
.city-card span {
    color: #7A8590;
    font-size: 12px;
    margin-top: 4px;
}

.business-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
}

.business-card {
    background: white;
    border: 1px solid #E6E2DA;
    border-radius: 12px;
    padding: 22px;
    transition: .2s;
}

.business-top {
    display: flex;
    gap: 14px;
}

.business-logo {
    width: 55px;
    height: 55px;
    flex: 0 0 55px;
    border-radius: 10px;
    background: #FBF6EC;
    color: #C08A2E;
    display: grid;
    place-items: center;
    font-weight: 800;
}

.business-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    border-radius: 10px;
}

.business-card h3 {
    margin: 2px 0 5px;
    font-size: 17px;
}

.business-card h3 a:hover {
    color: #C08A2E;
}

.category-name {
    color: #C08A2E;
    font-size: 12px;
    font-weight: 700;
}

.business-info {
    margin-top: 18px;
    color: #5A6673;
    font-size: 13px;
    display: grid;
    gap: 7px;
}

.description {
    color: #6B7580;
    font-size: 13px;
    margin-bottom: 0;
}

.city-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 12px;
}

.city-card {
    padding: 20px;
    background: white;
    border: 1px solid #E6E2DA;
    border-radius: 12px;
    transition: .2s;
}

.city-card strong,
.city-card span {
    display: block;
}

.business-cta {
    background: #16202D;
    color: white;
    padding: 50px 0;
}

.cta-inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 25px;
}

.cta-inner h2 {
    margin: 0 0 7px;
}

.cta-inner p {
    margin: 0;
    color: #C5CDD5;
}

.cta-button {
    background: #C08A2E;
    padding: 13px 22px;
    border-radius: 8px;
    font-weight: 800;
    white-space: nowrap;
}

footer {
    background: #111923;
    color: #D9E0E8;
    padding: 60px 0 20px;
}

.footer-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 45px;
}

footer h4 {
    margin-top: 0;
    color: white;
}

footer a {
    display: block;
    margin: 10px 0;
    color: #AEB8C3;
}

footer a:hover {
    color: #F0D8A8;
}

footer p {
    color: #AEB8C3;
    max-width: 350px;
}

.copyright {
    margin-top: 45px;
    padding-top: 20px;
    border-top: 1px solid #303A45;
    color: #8F9AA6;
    font-size: 13px;
}

@media (max-width: 900px) {
    .menu {
        display: none;
    }

    .category-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .business-grid {
        grid-template-columns: 1fr 1fr;
    }

    .city-grid {
        grid-template-columns: repeat(3, 1fr);
    }

    .footer-grid {
        grid-template-columns: 1fr 1fr;
    }
}

@media (max-width: 650px) {
    .wrap {
        width: min(100% - 28px, 1180px);
    }

    .nav {
        min-height: 65px;
    }

    .login {
        padding: 8px 12px;
        font-size: 12px;
    }

    .hero {
        min-height: 500px;
    }

    .search {
        grid-template-columns: 1fr;
        gap: 5px;
    }

    .search-field + .search-field {
        border-left: 0;
        border-top: 1px solid #E6E2DA;
    }

    .search button {
        min-height: 48px;
    }

    .section-heading {
        align-items: flex-start;
        flex-direction: column;
    }

    .category-grid,
    .business-grid,
    .city-grid,
    .footer-grid {
        grid-template-columns: 1fr;
    }

    .cta-inner {
        align-items: flex-start;
        flex-direction: column;
    }
}
</style>