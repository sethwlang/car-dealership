<template>
    <div>
      <!-- Navigation Bar -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
          <router-link to="/" class="navbar-brand">Car Dealership</router-link>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <router-link to="/" class="nav-link">Car Search</router-link>
              </li>
              <li class="nav-item">
                <router-link to="/dealers" class="nav-link">Dealers</router-link>
              </li>
            </ul>
          </div>
        </div>
      </nav>
  
      <!-- Router View -->
      <div class="container mt-4">
        <router-view></router-view>
      </div>
    </div>
  </template>
  
  <script>
  export default {
  };
  </script>