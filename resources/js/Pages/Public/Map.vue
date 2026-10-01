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
                    <a href="/listings?featured=1">Featured</a>
                    <a href="/map" class="active">Map</a>
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
                    EXPLORE NEPAL
                </div>

                <h1>Business Map</h1>

                <p>
                    Find businesses and services across Nepal by location.
                </p>

            </div>
        </section>


        <!-- Map area -->
        <main class="wrap content">

            <div class="map-card">

                <div class="map-placeholder">

                    <div class="map-icon">
                        ⌖
                    </div>

                    <h2>Explore businesses on the map</h2>

                    <p>
                        The interactive YP Nepal business map will appear here.
                    </p>

                    <div class="map-note">
                        Business locations will use the latitude and longitude
                        stored in the YP Nepal directory.
                    </div>

                </div>

            </div>

        </main>


        <!-- CTA -->
        <section class="cta-section">
            <div class="wrap cta">

                <div>
                    <h2>Looking for a business?</h2>

                    <p>
                        Search businesses and services across Nepal.
                    </p>
                </div>

                <a href="/listings" class="cta-button">
                    Browse listings →
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
                    <a href="/listings?featured=1">Featured</a>
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
    padding: 50px 0 80px;
}

.map-card {
    background: white;
    border: 1px solid #E6E2DA;
    border-radius: 14px;
    overflow: hidden;
    min-height: 560px;
}

.map-placeholder {
    min-height: 560px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 40px;
    background:
        linear-gradient(
            90deg,
            rgba(230,226,218,.45) 1px,
            transparent 1px
        ),
        linear-gradient(
            rgba(230,226,218,.45) 1px,
            transparent 1px
        ),
        #F7F6F3;

    background-size: 45px 45px;
}

.map-icon {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: #F3E7D0;
    color: #C08A2E;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 34px;
    margin-bottom: 20px;
}

.map-placeholder h2 {
    margin: 0;
    font-size: 26px;
}

.map-placeholder p {
    color: #5A6673;
    margin: 10px 0 18px;
}

.map-note {
    max-width: 520px;
    padding: 13px 18px;
    border-radius: 8px;
    background: #FBF6EC;
    border: 1px solid #F3E7D0;
    color: #806020;
    font-size: 13px;
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


/* MOBILE */

@media (max-width: 900px) {

    .menu {
        display: none;
    }

}

@media (max-width: 600px) {

    .wrap {
        width: min(100% - 28px, 1180px);
    }

    .page-header {
        padding: 45px 0;
    }

    .map-card,
    .map-placeholder {
        min-height: 450px;
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