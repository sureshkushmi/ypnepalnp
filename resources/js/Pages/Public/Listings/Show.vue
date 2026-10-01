<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    listing: Object,
    related: Array,
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

        <!-- PAGE HERO / BREADCRUMB -->
        <section class="page-hero">
            <div class="wrap breadcrumb">
                <Link href="/">Home</Link>
                <span class="sep">/</span>
                <Link
                    v-if="listing.categories && listing.categories.length"
                    :href="`/category/${listing.categories[0].id}`"
                >
                    {{ listing.categories[0].name }}
                </Link>
                <template v-else>
                    <Link href="/listings">Listings</Link>
                </template>
                <span class="sep">/</span>
                <span class="current">{{ listing.name }}</span>
            </div>
        </section>

        <!-- MAIN CONTENT -->
        <main class="wrap listing-layout">

            <!-- LEFT: DETAILS -->
            <div class="listing-main">

                <div class="listing-head card">

                    <div class="logo-box">
                        <img
                            v-if="listing.logo"
                            :src="`/uploads/listings/${listing.logo}`"
                            :alt="listing.name"
                        />
                        <span v-else>{{ listing.name.charAt(0) }}</span>
                    </div>

                    <div class="head-info">
                        <h1>{{ listing.name }}</h1>

                        <div
                            v-if="listing.categories && listing.categories.length"
                            class="cat-pills"
                        >
                            <Link
                                v-for="cat in listing.categories"
                                :key="cat.id"
                                :href="`/category/${cat.id}`"
                                class="pill"
                            >
                                {{ cat.name }}
                            </Link>
                        </div>

                        <div class="head-meta" v-if="listing.city">
                            📍
                            {{ listing.city.name }}
                            <template v-if="listing.add1">
                                · {{ listing.add1 }}
                            </template>
                        </div>
                    </div>

                </div>

                <!-- MAIN IMAGE -->
                <div v-if="listing.image" class="card image-card">
                    <img
                        :src="`/uploads/listings/${listing.image}`"
                        :alt="listing.name"
                    />
                </div>

                <!-- ABOUT -->
                <div v-if="listing.description" class="card">
                    <h2 class="card-title">About</h2>
                    <div
                        class="listing-description"
                        v-html="listing.description"
                    ></div>
                </div>

                <!-- ADDITIONAL INFO -->
                <div class="card">
                    <h2 class="card-title">Business Information</h2>

                    <div class="info-grid">

                        <div v-if="listing.contact_person" class="info-row">
                            <span class="info-label">Contact Person</span>
                            <span class="info-value">{{ listing.contact_person }}</span>
                        </div>

                        <div v-if="listing.pobox" class="info-row">
                            <span class="info-label">P.O. Box</span>
                            <span class="info-value">{{ listing.pobox }}</span>
                        </div>

                        <div v-if="listing.onDate" class="info-row">
                            <span class="info-label">Listed Since</span>
                            <span class="info-value">{{ listing.onDate }}</span>
                        </div>

                        <div v-if="listing.visited" class="info-row">
                            <span class="info-label">Views</span>
                            <span class="info-value">{{ listing.visited }}</span>
                        </div>

                    </div>
                </div>

            </div>

            <!-- RIGHT: SIDEBAR -->
            <aside class="listing-side">

                <!-- CONTACT CARD -->
                <div class="card contact-card">
                    <h2 class="card-title">Contact</h2>

                    <div class="contact-list">

                        <a
                            v-if="listing.phone1"
                            :href="`tel:${listing.phone1}`"
                            class="contact-item"
                        >
                            <span class="ci-icon">☎</span>
                            <span>{{ listing.phone1 }}</span>
                        </a>

                        <a
                            v-if="listing.phone2"
                            :href="`tel:${listing.phone2}`"
                            class="contact-item"
                        >
                            <span class="ci-icon">☎</span>
                            <span>{{ listing.phone2 }}</span>
                        </a>

                        <a
                            v-if="listing.email"
                            :href="`mailto:${listing.email}`"
                            class="contact-item"
                        >
                            <span class="ci-icon">✉</span>
                            <span>{{ listing.email }}</span>
                        </a>

                        <a
                            v-if="listing.url"
                            :href="listing.url"
                            target="_blank"
                            class="contact-item"
                        >
                            <span class="ci-icon">🌐</span>
                            <span class="url-text">{{ listing.url }}</span>
                        </a>

                        <a
                            v-if="listing.fax"
                            class="contact-item"
                        >
                            <span class="ci-icon">📠</span>
                            <span>{{ listing.fax }}</span>
                        </a>

                    </div>
                </div>

                <!-- ADDRESS CARD -->
                <div class="card">
                    <h2 class="card-title">Address</h2>

                    <div class="address-block">
                        <p v-if="listing.add1">{{ listing.add1 }}</p>
                        <p v-if="listing.add2">{{ listing.add2 }}</p>
                        <p v-if="listing.city">
                            {{ listing.city.name }}, Nepal
                        </p>
                    </div>

                    <a
                        v-if="listing.latitude && listing.longitude"
                        :href="`https://www.google.com/maps?q=${listing.latitude},${listing.longitude}`"
                        target="_blank"
                        class="map-link"
                    >
                        View on Google Maps →
                    </a>
                </div>

                <!-- CLAIM / CTA -->
                <div class="card cta-card">
                    <h3>Own this business?</h3>
                    <p>
                        Claim this listing and update your
                        business information.
                    </p>
                    <a href="/contact" class="cta-btn">
                        Claim Listing
                    </a>
                </div>

            </aside>
        </main>

        <!-- RELATED -->
        <section v-if="related && related.length" class="section">
            <div class="wrap">

                <div class="section-heading">
                    <div>
                        <h2>Similar businesses</h2>
                        <p>Other businesses you might be interested in.</p>
                    </div>

                    <Link
                        v-if="listing.categories && listing.categories.length"
                        :href="`/category/${listing.categories[0].id}`"
                        class="more"
                    >
                        View all →
                    </Link>
                </div>

                <div class="business-grid">

                    <article
                        v-for="item in related"
                        :key="item.id"
                        class="business-card"
                    >
                        <div class="business-top">

                            <div class="business-logo">
                                <img
                                    v-if="item.logo"
                                    :src="`/uploads/listings/${item.logo}`"
                                    :alt="item.name"
                                />
                                <span v-else>YP</span>
                            </div>

                            <div>
                                <h3>
                                    <Link :href="`/listing/${item.id}`">
                                        {{ item.name }}
                                    </Link>
                                </h3>
                                <div
                                    v-if="item.city"
                                    class="category-name"
                                >
                                    📍 {{ item.city.name }}
                                </div>
                            </div>

                        </div>

                        <div class="business-info">
                            <div v-if="item.phone1">
                                ☎ {{ item.phone1 }}
                            </div>
                        </div>
                    </article>

                </div>
            </div>
        </section>

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

/* BREADCRUMB HERO */
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
.breadcrumb .current { color: white; font-weight: 600; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

/* LAYOUT */
.listing-layout {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 24px;
    padding: 32px 0 60px;
    align-items: start;
}

.card {
    background: white;
    border: 1px solid #E6E2DA;
    border-radius: 14px;
    padding: 26px;
    margin-bottom: 20px;
}

.card-title {
    margin: 0 0 18px;
    font-size: 18px;
    font-weight: 800;
    padding-bottom: 12px;
    border-bottom: 1px solid #EEF0F2;
}

/* HEAD */
.listing-head {
    display: flex;
    gap: 20px;
    align-items: center;
}

.logo-box {
    width: 90px;
    height: 90px;
    flex: 0 0 90px;
    border-radius: 14px;
    background: #FBF6EC;
    color: #C08A2E;
    display: grid;
    place-items: center;
    font-size: 34px;
    font-weight: 800;
    overflow: hidden;
    border: 1px solid #F0E4CC;
}

.logo-box img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.head-info h1 {
    margin: 0 0 10px;
    font-size: clamp(22px, 3vw, 32px);
    letter-spacing: -0.5px;
}

.cat-pills { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 10px; }

.pill {
    background: #FBF6EC;
    color: #C08A2E;
    font-size: 12px;
    font-weight: 700;
    padding: 5px 13px;
    border-radius: 999px;
}

.pill:hover { background: #C08A2E; color: white; }

.head-meta { color: #5A6673; font-size: 14px; }

/* IMAGE */
.image-card { padding: 0; overflow: hidden; }

.image-card img {
    width: 100%;
    max-height: 420px;
    object-fit: cover;
    display: block;
}

/* DESCRIPTION */
.listing-description {
    color: #4A5560;
    font-size: 15px;
    line-height: 1.75;
}

.listing-description :deep(p) { margin: 0 0 12px; }

.listing-description :deep(span) {
    font-family: inherit !important;
    font-size: inherit !important;
    color: inherit !important;
    background: transparent !important;
}

.listing-description :deep(a) { color: #C08A2E; }

/* INFO GRID */
.info-grid { display: grid; gap: 2px; }

.info-row {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    padding: 12px 0;
    border-bottom: 1px solid #F2F0EB;
    font-size: 14px;
}

.info-row:last-child { border-bottom: 0; }
.info-label { color: #7A8590; font-weight: 600; }
.info-value { color: #16202D; font-weight: 600; text-align: right; }

/* SIDEBAR */
.listing-side { position: sticky; top: 94px; }

.contact-card { border-top: 4px solid #C08A2E; }

.contact-list { display: grid; gap: 6px; }

.contact-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 13px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    color: #3D4956;
    transition: .15s;
    word-break: break-all;
}

.contact-item:hover {
    background: #FBF6EC;
    color: #C08A2E;
}

.ci-icon {
    width: 34px;
    height: 34px;
    flex: 0 0 34px;
    display: grid;
    place-items: center;
    background: #FBF6EC;
    border-radius: 9px;
    font-size: 15px;
}

.url-text { font-size: 13px; }

/* ADDRESS */
.address-block p { margin: 0 0 6px; color: #4A5560; font-size: 14px; }

.map-link {
    display: inline-block;
    margin-top: 14px;
    color: #C08A2E;
    font-weight: 700;
    font-size: 14px;
}

.map-link:hover { text-decoration: underline; }

/* CTA */
.cta-card {
    background: #16202D;
    color: white;
    border: 0;
    text-align: center;
}

.cta-card h3 { margin: 0 0 8px; font-size: 18px; }
.cta-card p { margin: 0 0 18px; color: #AEB8C3; font-size: 14px; line-height: 1.6; }

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

/* SECTION */
.section { padding: 60px 0; }

.section-heading {
    display: flex;
    justify-content: space-between;
    align-items: end;
    gap: 20px;
    margin-bottom: 28px;
}

.section-heading h2 { margin: 0 0 7px; font-size: 28px; }
.section-heading p { margin: 0; color: #5A6673; }

.more { color: #C08A2E; font-weight: 700; white-space: nowrap; }

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

.business-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(22,32,45,.08);
}

.business-top { display: flex; gap: 14px; }

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

.business-card h3 { margin: 2px 0 5px; font-size: 17px; }
.business-card h3 a:hover { color: #C08A2E; }

.category-name { color: #5A6673; font-size: 12px; font-weight: 600; }

.business-info {
    margin-top: 18px;
    color: #5A6673;
    font-size: 13px;
    display: grid;
    gap: 7px;
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

    .listing-layout { grid-template-columns: 1fr; }
    .listing-side { position: static; }

    .business-grid { grid-template-columns: 1fr 1fr; }
}

@media (max-width: 650px) {
    .wrap { width: min(100% - 28px, 1180px); }

    .nav { min-height: 65px; }

    .login { padding: 8px 12px; font-size: 12px; }

    .listing-head { flex-direction: column; align-items: flex-start; }

    .section-heading { align-items: flex-start; flex-direction: column; }

    .business-grid { grid-template-columns: 1fr; }

    .info-row { flex-direction: column; gap: 4px; }
    .info-value { text-align: left; }

    .footer-grid { grid-template-columns: 1fr; }
}
</style>