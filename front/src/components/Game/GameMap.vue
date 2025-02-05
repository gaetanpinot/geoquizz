<template>
    <div id="carte" class="carte"></div>
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
      ligne: null
    }
  },
  mounted() {
    this.carte = L.map('carte').setView([46.603354, 1.888334], 6)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: ''
    }).addTo(this.carte)

    // Pose du marqueur d'estimation lors d'un clic sur la carte (si non confirmé)
    this.carte.on('click', e => {
      if (this.confirme) return;
      const { lat, lng } = e.latlng;
      if (this.marqueurEstimation) {
        this.marqueurEstimation.setLatLng([lat, lng]);
      } else {
        this.marqueurEstimation = L.marker([lat, lng]).addTo(this.carte);
      }
      this.$emit('marqueur-place', { lat, lon: lng })
    })

    /*this.carte.getContainer().addEventListener('mouseenter', () => {
      this.carte.getContainer().style.transform = "scale(1.5)";
    })

    this.carte.getContainer().addEventListener('mouseleave', () => {
      this.carte.getContainer().style.transform = "scale(1)";
    })*/
  },
  methods: {
    afficherResultats(coordCible, coordEstimation) {
      // Suppression des anciens marqueurs et de la ligne, le cas échéant
      if (this.marqueurCible) {
        this.carte.removeLayer(this.marqueurCible);
      }
      if (this.ligne) {
        this.carte.removeLayer(this.ligne);
      }
      // Définir une icône rouge pour la cible
      const iconeRouge = L.icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
      });
      // Placer le marqueur de la cible
      this.marqueurCible = L.marker([coordCible.lat, coordCible.lon], { icon: iconeRouge }).addTo(this.carte);
      // Tracer une ligne entre l'estimation et la cible
      this.ligne = L.polyline(
        [[coordEstimation.lat, coordEstimation.lon], [coordCible.lat, coordCible.lon]],
        { color: 'red' }
      ).addTo(this.carte);
    },
    calculerDistance(coordCible, coordEstimation) {
      const toRad = valeur => (valeur * Math.PI) / 180
      const R = 6371000
      const dLat = toRad(coordCible.lat - coordEstimation.lat)
      const dLon = toRad(coordCible.lon - coordEstimation.lon)
      const lat1 = toRad(coordEstimation.lat)
      const lat2 = toRad(coordCible.lat)
      const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1) * Math.cos(lat2) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      return R * c;
    },
    reinitialiserCarte() {
      if (this.marqueurEstimation) {
        this.carte.removeLayer(this.marqueurEstimation);
        this.marqueurEstimation = null;
      }
      if (this.marqueurCible) {
        this.carte.removeLayer(this.marqueurCible);
        this.marqueurCible = null;
      }
      if (this.ligne) {
        this.carte.removeLayer(this.ligne);
        this.ligne = null;
      }
    }
  }
}
</script>

<style scoped>
#carte-block {
  position: fixed;
  bottom: 20px;
  right: 20px;
  transition: all 0.3s ease;
  z-index: 1000;
}

.carte {
  height: 300px;
  width: 100%;
  transition: transform 0.3s ease;
  transform-origin: bottom left;
  border: 2px solid darkorange;
  border-radius: 10px 10px 10px 0px;
  overflow: hidden;
}

.carte:hover {
  transform: scale(1.5);
}

</style>
