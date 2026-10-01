<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    category: Object,
    listings: Object, // paginator: listings.data, listings.links
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
                <Link href="/categories">Categories</Link>
                <span class="sep">/</span>
                <span class="current">{{ category.name }}</span>
            </div>
        </section>

        <!-- CATEGORY HEAD -->
        <section class="wrap">
            <div class="cat-head">
                <h1>{{ category.name }}</h1>
                <p>
                    {{ listings.total }}
                    {{ listings.total === 1 ? 'listing' : 'listings' }} found
                </p>
            </div>
        </section>

        <!-- LISTINGS -->
        <main class="wrap listings-area">

            <div v-if="listings.data.length" class="listing-grid">

                <article
                    v-for="listing in listings.data"
                    :key="listing.id"
                    class="listing-card"
                >
                    <div class="business-top">

                        <div class="business-logo">
                            <img
                                v-if="listing.logo"
                                :src="`/uploads/listings/${listing.logo}`"
                                :alt="listing.name"
                            />
                            <span v-else>{{ listing.name.charAt(0) }}</span>
                        </div>

                        <div class="listing-body">
                            <h3>
                                <Link :href="`/listing/${listing.id}`">
                                    {{ listing.name }}
                                </Link>
                            </h3>

                            <div v-if="listing.city" class="listing-meta">
                                📍 {{ listing.city.name }}
                                <template v-if="listing.add1">
                                    · {{ listing.add1 }}
                                </template>
                            </div>

                            <div v-if="listing.phone1" class="listing-meta">
                                ☎ {{ listing.phone1 }}
                            </div>

                            <div
                                v-if="listing.description"
                                class="listing-desc"
                                v-html="listing.description"
                            ></div>
                        </div>

                    </div>

                    <Link
                        :href="`/listing/${listing.id}`"
                        class="view-btn"
                    >
                        View Details →
                    </Link>
                </article>

            </div>

            <!-- EMPTY STATE -->
            <div v-else class="empty card">
                <div class="empty-icon">🔍</div>
                <h2>No listings found</h2>
                <p>
                    There are currently no active listings in
                    this category.
                </p>
                <Link href="/categories" class="cta-btn">
                    Browse other categories
                </Link>
            </div>

            <!-- PAGINATION -->
            <div v-if="listings.links.length > 3" class="pagination">
                <Link
                    v-for="link in listings.links"
                    :key="link.label"
                    :href="link.url || '#'"
                    class="page-link"
                    :class="{
                        active: link.active,
                        disabled: !link.url,
                    }"
                    v-html="link.label"
                ></Link>
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

/* CATEGORY HEAD */
.cat-head {
    padding: 36px 0 8px;
}

.cat-head h1 {
    margin: 0 0 6px;
    font-size: clamp(26px, 4vw, 36px);
    letter-spacing: -0.8px;
}

.cat-head p { margin: 0; color: #7A8590; font-size: 14px; font-weight: 600; }

/* LISTINGS */
.listings-area { padding: 24px 0 60px; }

.listing-grid { display: grid; gap: 16px; }

.listing-card {
    background: white;
    border: 1px solid #E6E2DA;
    border-radius: 14px;
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    transition: .2s;
}

.listing-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(22,32,45,.08);
}

.business-top { display: flex; gap: 16px; }

.business-logo {
    width: 64px;
    height: 64px;
    flex: 0 0 64px;
    border-radius: 12px;
    background: #FBF6EC;
    color: #C08A2E;
    display: grid;
    place-items: center;
    font-size: 22px;
    font-weight: 800;
    overflow: hidden;
    border: 1px solid #F0E4CC;
}

.business-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.listing-body { flex: 1; min-width: 0; }

.listing-body h3 { margin: 0 0 6px; font-size: 19px; }
.listing-body h3 a:hover { color: #C08A2E; }

.listing-meta {
    color: #5A6673;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 5px;
}

.listing-desc {
    color: #7A8590;
    font-size: 13px;
    line-height: 1.6;
    margin-top: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.listing-desc :deep(p) { margin: 0; }

.listing-desc :deep(span) {
    font-family: inherit !important;
    font-size: inherit !important;
    color: inherit !important;
    background: transparent !important;
}

.view-btn {
    align-self: flex-start;
    color: #C08A2E;
    font-weight: 700;
    font-size: 14px;
}

.view-btn:hover { text-decoration: underline; }

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

/* PAGINATION */
.pagination {
    display: flex;
    justify-content: center;
    gap: 6px;
    margin-top: 32px;
    flex-wrap: wrap;
}

.page-link {
    min-width: 40px;
    height: 40px;
    display: grid;
    place-items: center;
    padding: 0 12px;
    border-radius: 9px;
    border: 1px solid #E6E2DA;
    background: white;
    color: #3D4956;
    font-size: 14px;
    font-weight: 700;
    transition: .15s;
}

.page-link:hover { border-color: #C08A2E; color: #C08A2E; }

.page-link.active {
    background: #C08A2E;
    border-color: #C08A2E;
    color: white;
}

.page-link.disabled {
    opacity: .4;
    pointer-events: none;
}

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
}

@media (max-width: 650px) {
    .wrap { width: min(100% - 28px, 1180px); }

    .nav { min-height: 65px; }

    .login { padding: 8px 12px; font-size: 12px; }

    .business-top { flex-direction: column; }

    .footer-grid { grid-template-columns: 1fr; }
}
</style>