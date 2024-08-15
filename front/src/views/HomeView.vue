<script setup lang="ts">
import {useRoute} from "vue-router";
import {useStorage} from "@vueuse/core";
import {computed, onMounted} from "vue";

const route = useRoute();

const spotifyAccessToken = useStorage<string|undefined>("spotifyAccessToken", undefined)
const spotifyRefreshToken = useStorage<string|undefined>("spotifyRefreshToken", undefined)
const stravaAccessToken = useStorage<string|undefined>("stravaAccessToken", undefined)
const stravaRefreshToken = useStorage<string|undefined>("stravaRefreshToken", undefined)

const isAuthenticatedToSpotify = computed<boolean>(() => {
  return !!spotifyAccessToken.value && !!spotifyRefreshToken.value
})

const isAuthenticatedToStrava = computed<boolean>(() => {
  return !!stravaAccessToken.value && !!stravaRefreshToken.value
})

onMounted(() => {
  if (route.query.service === 'strava' && route.query.accessToken && route.query.refreshToken) {
    stravaAccessToken.value = route.query.accessToken as string;
    stravaRefreshToken.value = route.query.refreshToken as string;
  }

  if (route.query.service === 'spotify' && route.query.accessToken && route.query.refreshToken) {
    spotifyAccessToken.value = route.query.accessToken as string;
    spotifyRefreshToken.value = route.query.refreshToken as string;
  }
})
</script>

<template>
  <main>
    <a href="https://localhost/spotify/connect">
      <button :disabled="isAuthenticatedToSpotify">
        Connect to Spotify
      </button>
    </a>
    <p v-if="isAuthenticatedToSpotify">Connected to spotify</p>
    <a href="https://localhost/strava/connect">
      <button :disabled="isAuthenticatedToStrava">
        Connect to Strava
      </button>
    </a>
    <p v-if="isAuthenticatedToStrava">Connected to Strava</p>
    <button v-if="isAuthenticatedToSpotify && isAuthenticatedToStrava">Next</button>
  </main>
</template>
