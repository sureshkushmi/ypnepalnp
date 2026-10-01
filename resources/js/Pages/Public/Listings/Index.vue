<script setup>
defineProps({
    listings: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="page">

        <!-- Header -->
        <header class="header">
            <div class="wrap nav">

                <a href="/" class="brand">
                    <div class="brand-mark">YP</div>

                    <div>
                        <strong>YP <span>Nepal</span></strong>
                        <small>Nepal Business Directory</small>
                    </div>
                </a>

                <nav class="menu">
                    <a href="/">Home</a>
                    <a href="/categories">Categories</a>
                    <a href="/locations">Locations</a>
                    <a href="/listings?featured=1" class="active">
                        Featured
                    </a>
                    <a href="/map">Map</a>
                </nav>

                <a href="/login" class="login">
                    Login
                </a>

            </div>
        </header>


        <!-- Page heading -->
        <section class="page-header">
            <div class="wrap">

                <div class="eyebrow">
                    YP NEPAL
                </div>

                <h1>Featured Businesses</h1>

                <p>
                    Discover businesses and services worth knowing across Nepal.
                </p>

            </div>
        </section>


        <!-- Listings -->
        <main class="wrap content">

            <div class="section-head">

                <div>
                    <h2>Featured businesses</h2>

                    <p>
                        Businesses selected for greater visibility on YP Nepal.
                    </p>
                </div>

                <div class="count" v-if="listings.total">
                    {{ listings.total }} businesses
                </div>

            </div>


            <!-- Empty -->
            <div
                v-if="!listings.data || listings.data.length === 0"
                class="empty"
            >
                <div class="empty-icon">⌕</div>

                <h3>No featured businesses found</h3>

                <p>
                    There are currently no featured businesses available.
                </p>

                <a href="/listings" class="gold-button">
                    Browse all businesses
                </a>
            </div>


            <!-- Listing cards -->
            <div v-else class="listing-grid">

                <article
                    v-for="listing in listings.data"
                    :key="listing.id"
                    class="listing-card"
                >

                    <!-- Top -->
                    <div class="listing-top">

                        <div class="avatar">
                            {{ listing.name?.substring(0, 2).toUpperCase() }}
                        </div>

                        <div class="listing-title">

                            <a
                                :href="`/listing/${listing.id}`"
                                class="business-name"
                            >
                                {{ listing.name }}
                            </a>

                            <div class="verified">
                                <span>✓</span>
                                Featured business
                            </div>

                        </div>

                    </div>


                    <!-- Information -->
                    <div class="meta">

                        <div v-if="listing.city">
                            <span class="meta-icon">⌖</span>
                            {{ listing.city.name }}
                        </div>

                        <div v-if="listing.add1">
                            <span class="meta-icon">⌂</span>
                            {{ listing.add1 }}
                        </div>

                        <div v-if="listing.phone1">
                            <span class="meta-icon">☎</span>
                            {{ listing.phone1 }}
                        </div>

                    </div>


                    <!-- Categories -->
                    <div
                        v-if="listing.categories && listing.categories.length"
                        class="categories"
                    >

                        <a
                            v-for="category in listing.categories.slice(0, 2)"
                            :key="category.id"
                            :href="`/category/${category.id}`"
                            class="tag"
                        >
                            {{ category.name }}
                        </a>

                    </div>


                    <!-- Footer -->
                    <div class="card-footer">

                        <a
                            :href="`/listing/${listing.id}`"
                            class="view-business"
                        >
                            View business
                            <span>→</span>
                        </a>

                    </div>

                </article>

            </div>


            <!-- Pagination -->
            <div
                v-if="listings.links && listings.links.length > 3"
                class="pagination"
            >

                <a
                    v-for="link in listings.links"
                    :key="link.label"
                    :href="link.url || '#'"
                    :class="[
                        'page-link',
                        { active: link.active },
                        { disabled: !link.url }
                    ]"
                    v-html="link.label"
                />

            </div>

        </main>


        <!-- CTA -->
        <section class="cta-section">
            <div class="wrap cta">

                <div>
                    <h2>Looking for a business?</h2>

                    <p>
                        Search thousands of businesses and services across Nepal.
                    </p>
                </div>

                <a href="/listings" class="cta-button">
                    Browse all listings →
                </a>

            </div>
        </section>


        <!-- Footer -->
        <footer class="footer">
            <div class="wrap footer-inner">

                <div>
                    <strong class="footer-brand">
                        YP <span>Nepal</span>
                    </strong>

                    <p>
                        Nepal Business Directory
                    </p>
                </div>

                <div class="footer-links">
                    <a href="/">Home</a>
                    <a href="/categories">Categories</a>
                    <a href="/locations">Locations</a>
                    <a href="/map">Map</a>
                    <a href="/contact">Contact</a>
                </div>

            </div>
        </footer>

    </div>
</template>


<style scoped>

:global(*) {
    box-sizing: border-box;
}

:global(body) {
    margin: 0;
    background: #FBFAF8;
    color: #16202D;
    font-family:
        "Plus Jakarta Sans",
        system-ui,
        -apple-system,
        "Segoe UI",
        Roboto,
        Arial,
        sans-serif;
}

:global(a) {
    color: inherit;
    text-decoration: none;
}

.page {
    min-height: 100vh;
    background: #FBFAF8;
}

.wrap {
    width: min(1180px, calc(100% - 40px));
    margin: 0 auto;
}


/* HEADER */

.header {
    background: #ffffff;
    border-bottom: 1px solid #E6E2DA;
    position: sticky;
    top: 0;
    z-index: 20;
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

.brand-mark {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #C08A2E;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 13px;
}

.brand strong {
    display: block;
    font-size: 20px;
    line-height: 1.1;
    letter-spacing: -0.5px;
}

.brand strong span {
    color: #C08A2E;
}

.brand small {
    display: block;
    color: #5A6673;
    font-size: 10px;
    margin-top: 3px;
}

.menu {
    display: flex;
    align-items: center;
    gap: 26px;
    font-size: 14px;
    font-weight: 600;
    color: #3D4956;
}

.menu a:hover,
.menu a.active {
    color: #C08A2E;
}

.login {
    border: 1.5px solid #C08A2E;
    color: #C08A2E;
    padding: 9px 20px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 700;
}


/* PAGE HEADER */

.page-header {
    background: #FBF6EC;
    border-bottom: 1px solid #E6E2DA;
    padding: 65px 0 60px;
}

.eyebrow {
    color: #C08A2E;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 1.5px;
    margin-bottom: 10px;
}

.page-header h1 {
    margin: 0;
    font-size: clamp(34px, 5vw, 50px);
    letter-spacing: -1.5px;
    line-height: 1.1;
}

.page-header p {
    margin: 15px 0 0;
    color: #5A6673;
    font-size: 16px;
}


/* CONTENT */

.content {
    padding: 55px 0 80px;
}

.section-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 20px;
    margin-bottom: 28px;
}

.section-head h2 {
    margin: 0;
    font-size: 27px;
    letter-spacing: -0.7px;
}

.section-head p {
    margin: 7px 0 0;
    color: #5A6673;
}

.count {
    color: #5A6673;
    font-size: 13px;
}


/* CARDS */

.listing-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.listing-card {
    background: white;
    border: 1px solid #E6E2DA;
    border-radius: 12px;
    padding: 22px;
    transition:
        transform .2s ease,
        box-shadow .2s ease,
        border-color .2s ease;
}

.listing-card:hover {
    transform: translateY(-3px);
    border-color: #D7B875;
    box-shadow: 0 12px 30px rgba(22, 32, 45, .08);
}

.listing-top {
    display: flex;
    gap: 13px;
    align-items: flex-start;
}

.avatar {
    width: 52px;
    height: 52px;
    flex: 0 0 52px;
    border-radius: 12px;
    background: #F3E7D0;
    color: #A16E1C;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 15px;
}

.listing-title {
    min-width: 0;
}

.business-name {
    display: block;
    font-size: 17px;
    font-weight: 800;
    line-height: 1.3;
}

.business-name:hover {
    color: #C08A2E;
}

.verified {
    margin-top: 6px;
    color: #1C8C5A;
    font-size: 12px;
    font-weight: 600;
}

.verified span {
    margin-right: 4px;
}

.meta {
    margin-top: 20px;
    color: #5A6673;
    font-size: 13px;
    line-height: 1.8;
}

.meta-icon {
    color: #C08A2E;
    display: inline-block;
    width: 20px;
}

.categories {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    margin-top: 17px;
}

.tag {
    background: #FBF6EC;
    color: #9A681C;
    border: 1px solid #F3E7D0;
    border-radius: 999px;
    padding: 5px 9px;
    font-size: 11px;
    font-weight: 700;
}

.tag:hover {
    background: #F3E7D0;
}

.card-footer {
    border-top: 1px solid #E6E2DA;
    margin-top: 20px;
    padding-top: 16px;
}

.view-business {
    color: #C08A2E;
    font-size: 13px;
    font-weight: 700;
}

.view-business span {
    margin-left: 4px;
}


/* EMPTY */

.empty {
    text-align: center;
    background: white;
    border: 1px solid #E6E2DA;
    border-radius: 12px;
    padding: 70px 20px;
}

.empty-icon {
    font-size: 35px;
    color: #C08A2E;
}

.empty h3 {
    margin: 15px 0 7px;
}

.empty p {
    color: #5A6673;
}

.gold-button {
    display: inline-block;
    margin-top: 15px;
    background: #C08A2E;
    color: white;
    padding: 11px 20px;
    border-radius: 8px;
    font-weight: 700;
}


/* PAGINATION */

.pagination {
    display: flex;
    justify-content: center;
    gap: 7px;
    margin-top: 40px;
    flex-wrap: wrap;
}

.page-link {
    min-width: 38px;
    height: 38px;
    padding: 0 11px;
    border: 1px solid #E6E2DA;
    background: white;
    border-radius: 7px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #3D4956;
    font-size: 13px;
}

.page-link:hover,
.page-link.active {
    background: #C08A2E;
    border-color: #C08A2E;
    color: white;
}

.page-link.disabled {
    opacity: .45;
    pointer-events: none;
}


/* CTA */

.cta-section {
    background: #16202D;
    color: white;
}

.cta {
    min-height: 210px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 30px;
}

.cta h2 {
    margin: 0;
    font-size: 28px;
}

.cta p {
    margin: 8px 0 0;
    color: #C9D0D8;
}

.cta-button {
    background: #C08A2E;
    color: white;
    padding: 13px 20px;
    border-radius: 8px;
    font-weight: 700;
    white-space: nowrap;
}


/* FOOTER */

.footer {
    background: #111923;
    color: #AEB8C3;
}

.footer-inner {
    min-height: 150px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 30px;
}

.footer-brand {
    color: white;
    font-size: 20px;
}

.footer-brand span {
    color: #C08A2E;
}

.footer p {
    margin: 5px 0 0;
    font-size: 12px;
}

.footer-links {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    font-size: 13px;
}

.footer-links a:hover {
    color: white;
}


/* RESPONSIVE */

@media (max-width: 900px) {

    .menu {
        display: none;
    }

    .listing-grid {
        grid-template-columns: repeat(2, 1fr);
    }

}

@media (max-width: 600px) {

    .wrap {
        width: min(100% - 28px, 1180px);
    }

    .login {
        padding: 8px 14px;
    }

    .page-header {
        padding: 45px 0;
    }

    .section-head {
        align-items: flex-start;
        flex-direction: column;
    }

    .listing-grid {
        grid-template-columns: 1fr;
    }

    .cta {
        padding: 35px 0;
        flex-direction: column;
        align-items: flex-start;
    }

    .footer-inner {
        padding: 35px 0;
        flex-direction: column;
        align-items: flex-start;
    }

}

</style>