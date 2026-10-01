<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    categories: {
        type: Array,
        default: () => [],
    },
})
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
                    <svg class="mark" viewBox="0 0 40 40" aria-hidden="true">
                        <path
                            d="M20 3c-7 0-12.5 5.4-12.5 12.1C7.5 24.4 20 37 20 37s12.5-12.6 12.5-21.9C32.5 8.4 27 3 20 3z"
                            fill="#C08A2E"
                        />
                        <circle cx="20" cy="15" r="5.4" fill="#fff" />
                    </svg>
                    <span>
                        <b>YP<span>Nepal</span></b>
                        <small>Nepal Business Directory</small>
                    </span>
                </Link>

                <nav class="menu">
                    <Link href="/categories">Categories</Link>
                    <Link href="/locations">Locations</Link>
                    <Link href="/listings?featured=1">Featured</Link>
                    <Link href="/map">Map</Link>
                </nav>

                <a href="/login" class="login">Member Login</a>
            </div>
        </header>

        <!-- BREADCRUMB -->
        <section class="page-hero">
            <div class="wrap breadcrumb">
                <Link href="/">Home</Link>
                <span class="sep">/</span>
                <span class="current">Categories</span>
            </div>
        </section>

        <!-- HEADING -->
        <section class="wrap">
            <div class="page-head">
                <h1>Browse Categories</h1>
                <p>
                    {{ categories.length }}
                    {{ categories.length === 1 ? 'category' : 'categories' }}
                    available
                </p>
            </div>
        </section>

        <!-- CATEGORY GRID -->
        <main class="wrap categories-area">

            <div v-if="categories.length" class="category-grid">

                <Link
                    v-for="category in categories"
                    :key="category.id"
                    :href="`/category/${category.id}`"
                    class="category-card"
                >
                    <div class="category-icon">
                        <svg
                            width="22"
                            height="22"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.2"
                        >
                            <path d="M9 18l6-6-6-6" />
                        </svg>
                    </div>

                    <div class="category-info">
                        <strong>{{ category.name }}</strong>
                        <span>
                            {{ category.listings_count }}
                            {{ category.listings_count === 1 ? 'listing' : 'listings' }}
                        </span>
                    </div>
                </Link>

            </div>

            <!-- EMPTY -->
            <div v-else class="empty card">
                <div class="empty-icon">🔍</div>
                <h2>No categories found</h2>
                <p>Categories will appear here soon.</p>
                <Link href="/" class="cta-btn">Back to Home</Link>
            </div>

        </main>

        <!-- FOOTER -->
        <footer>
            <div class="wrap footer-grid">
                <div>
                    <Link href="/" class="brand">
                        <svg class="mark" viewBox="0 0 40 40">
                            <path
                                d="M20 3c-7 0-12.5 5.4-12.5 12.1C7.5 24.4 20 37 20 37s12.5-12.6 12.5-21.9C32.5 8.4 27 3 20 3z"
                                fill="#C08A2E"
                            />
                            <circle cx="20" cy="15" r="5.4" fill="#fff" />
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
                    <Link href="/categories">All categories</Link>
                    <Link href="/locations">Districts</Link>
                    <Link href="/listings?featured=1">Featured businesses</Link>
                </div>

                <div>
                    <h4>For businesses</h4>
                    <a href="/add-listing">Add your business</a>
                    <a href="/advertise">Advertising</a>
                    <a href="/contact">Contact us</a>
                </div>
            </div>

            <div class="wrap copyright">
                © {{ new Date().getFullYear() }} YP Nepal
            </div>
        </footer>

    </div>
</template>

<style scoped>
:global(*) { box-sizing: border-box; }

:global(body) {
    margin: 0;
    background: #FBFAF8;
    color: #16202D;
    font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

:global(a) { text-decoration: none; color: inherit; }

.yp-page { min-height: 100vh; }

.wrap {
    width: min(1180px, calc(100% - 40px));
    margin: auto;
}

/* STRIP */
.strip { background: #16202D; color: #D9E0E8; font-size: 13px; }

.strip-inner {
    min-height: 38px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
}

.strip a { color: #F0D8A8; font-weight: 700; }

/* HEADER */
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

.brand { display: flex; align-items: center; gap: 10px; }
.brand .mark { width: 34px; height: 34px; }
.brand b { display: block; font-size: 21px; font-weight: 800; line-height: 1.1; }
.brand b span { color: #C08A2E; }
.brand small { display: block; font-size: 11px; color: #5A6673; }

.menu { display: flex; gap: 28px; font-size: 14px; font-weight: 600; color: #3D4956; }
.menu a:hover { color: #C08A2E; }

.login {
    border: 1.5px solid #C08A2E;
    color: #C08A2E;
    padding: 9px 20px;
    border-radius: 999px;
    font-weight: 700;
}

/* BREADCRUMB */
.page-hero {
    background: linear-gradient(135deg, #16202D, #2A3542);
    color: white;
    padding: 22px 0;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    color: #AEB8C3;
}

.breadcrumb a { color: #F0D8A8; font-weight: 600; }
.breadcrumb a:hover { text-decoration: underline; }
.breadcrumb .sep { color: #5A6673; }
.breadcrumb .current { color: white; font-weight: 600; }

/* HEAD */
.page-head { padding: 36px 0 8px; }

.page-head h1 {
    margin: 0 0 6px;
    font-size: clamp(26px, 4vw, 36px);
    letter-spacing: -0.8px;
}

.page-head p { margin: 0; color: #7A8590; font-size: 14px; font-weight: 600; }

/* CATEGORIES */
.categories-area { padding: 24px 0 60px; }

.category-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
}

.category-card {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: white;
    border: 1px solid #E6E2DA;
    border-radius: 14px;
    transition: .2s;
}

.category-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(22,32,45,.08);
    border-color: #C08A2E;
}

.category-icon {
    width: 46px;
    height: 46px;
    flex: 0 0 46px;
    border-radius: 11px;
    background: #FBF6EC;
    color: #C08A2E;
    display: grid;
    place-items: center;
}

.category-card:hover .category-icon {
    background: #C08A2E;
    color: white;
}

.category-info { flex: 1; min-width: 0; }

.category-info strong {
    display: block;
    font-size: 15px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.category-info span {
    display: block;
    color: #7A8590;
    font-size: 12px;
    margin-top: 3px;
}

/* EMPTY */
.card {
    background: white;
    border: 1px solid #E6E2DA;
    border-radius: 14px;
    padding: 40px;
}

.empty { text-align: center; }
.empty-icon { font-size: 40px; margin-bottom: 12px; }
.empty h2 { margin: 0 0 8px; }
.empty p { margin: 0 0 20px; color: #7A8590; }

.cta-btn {
    display: inline-block;
    background: #C08A2E;
    color: white;
    padding: 12px 28px;
    border-radius: 8px;
    font-weight: 800;
    font-size: 14px;
}

.cta-btn:hover { background: #A97622; }

/* FOOTER */
footer {
    background: #111923;
    color: #D9E0E8;
    padding: 60px 0 20px;
}

.footer-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    gap: 45px;
}

footer h4 { margin-top: 0; color: white; }

footer a {
    display: block;
    margin: 10px 0;
    color: #AEB8C3;
}

footer a:hover { color: #F0D8A8; }

footer p { color: #AEB8C3; max-width: 350px; }

.copyright {
    margin-top: 45px;
    padding-top: 20px;
    border-top: 1px solid #303A45;
    color: #8F9AA6;
    font-size: 13px;
}

/* RESPONSIVE */
@media (max-width: 900px) {
    .menu { display: none; }
    .category-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 900px) {
    .menu { display: none; }
    .city-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 650px) {
    .wrap { width: min(100% - 28px, 1180px); }

    .nav { min-height: 65px; }

    .login { padding: 8px 12px; font-size: 12px; }

    .city-grid { grid-template-columns: 1fr; }

    .footer-grid { grid-template-columns: 1fr; }
}
</style>