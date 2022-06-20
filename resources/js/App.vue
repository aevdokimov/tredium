<template>
    
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <router-link to="/" class="navbar-brand">Тредиум</router-link>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">                    
                    <router-link to="/" class="nav-link">На главную</router-link>
                    <router-link to="/articles" :class="[$route.path.includes('articles') ? 'active' : '', 'nav-link']">Каталог статей</router-link>                    
                </div>
            </div>
        </div>
    </nav>    

    <router-view :key="$route.fullPath"></router-view>
</template>
