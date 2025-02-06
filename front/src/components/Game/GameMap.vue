<template>

  <div id="carte-block" :class="{ fullscreen: isFullscreen }">
    <button v-if="isMobile && isFullscreen" class="back-button" @click="exitFullscreen">Fermer </button>
    <button v-if="isMobile && !isFullscreen" class="expand-button" @click="enterFullscreen">Ouvrir la carte</button>
    <div id="carte" class="carte"></div>
  </div>
</template>

<script>
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'

export default {
  name: 'GameMap',
  props: ['coordCible', 'confirme'],
  data() {
    return {
      carte: null,
      marqueurEstimation: null,
      marqueurCible: null,
      ligne: null,
      isFullscreen: false,
      isMobile: window.innerWidth <= 768
    }
  },
  mounted() {
    this.carte = L.map('carte').setView([46.603354, 1.888334], 6)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: ''
    }).addTo(this.carte)


    this.carte.on('click', e => {
      if (this.confirme || window.innerWidth < 768) return;
      const { lat, lng } = e.latlng;
      if (this.marqueurEstimation) {
        this.marqueurEstimation.setLatLng([lat, lng]);
      } else {
        this.marqueurEstimation = L.marker([lat, lng]).addTo(this.carte);
      }
      this.$emit('marqueur-place', { lat, lon: lng })
    })

    const obs = new ResizeObserver(() => {
      this.carte.invalidateSize();
    });
    obs.observe(document.getElementById('carte-block'));
    window.addEventListener('resize', this.handleResize);
    this.handleResize();
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.handleResize);
  },
  methods: {
    handleResize() {
      this.isMobile = window.innerWidth <= 768;
      if (this.isMobile && !this.isFullscreen) {
        this.carte.dragging.disable();
        this.carte.touchZoom.disable();
        this.carte.doubleClickZoom.disable();
        this.carte.scrollWheelZoom.disable();
      } else {
        this.carte.dragging.enable();
        this.carte.touchZoom.enable();
        this.carte.doubleClickZoom.enable();
        this.carte.scrollWheelZoom.enable();
      }
    },
    enterFullscreen() {
      this.isFullscreen = true;
      this.handleResize();
      this.carte.invalidateSize();
    },
    exitFullscreen() {
      this.isFullscreen = false;
      this.handleResize();
      this.carte.invalidateSize();
    }
  }
}
</script>

<style scoped>
#carte-block {
  position: fixed;
  bottom: 20px;
  left: 20px;
  transition: all 0.3s ease;
  z-index: 1000;
}

.carte {
  height: 300px;
  width: 300px;
  transition: all 0.5s ease;
  transform-origin: bottom left;
  border: 2px solid darkorange;
  border-radius: 10px;
  overflow: hidden;
}

@media (min-width: 769px) {
  .carte:hover {
    width: 80vw;
    height: calc(100vh - 70px);
  }
}

@media (max-width: 768px) {
  .carte {
    height: 100px;
    width: 80%;
    transition: transform 0.3s ease;
    transform-origin: bottom left;
    border: 2px solid darkorange;
    border-radius: 10px;
    overflow: hidden;
    pointer-events: none;
    visibility: hidden;
  }
}

#carte-block.fullscreen {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 2000;
  background: white;
  padding: 0;
}

#carte-block.fullscreen .carte {
  height: 100vh;
  width: 100%;
  border-radius: 0;
  pointer-events: auto;
  visibility: visible;
}

@media (max-width: 768px) {

  .expand-button,
  .back-button {
    display: block;
    position: absolute;
    padding: 8px 12px;
    width: 100px;
    background: darkorange;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    z-index: 2001;
    transition: background 0.3s ease;
  }

  .expand-button {
    top: 60px;
    left: 10px;
  }

  .back-button {
    bottom: 10px;
    left: 10px;
  }

  .expand-button:hover,
  .back-button:hover {
    background: orangered;
  }
}
</style>
