<template>
  <div class="container mt-4">
    <!-- Filter by Manufacturer -->
    <div class="row mb-3">
      <div class="col-md-6">
        <label for="manufacturerFilter">Filter by Manufacturer:</label>
        <select class="form-control" id="manufacturerFilter" v-model="selectedManufacturer" @change="filterByManufacturer">
          <option value="">All Manufacturers</option>
          <option v-for="manufacturer in manufacturers" :key="manufacturer.id" :value="manufacturer.id">{{ manufacturer.name }}</option>
        </select>
      </div>
    </div>

    <!-- Car List -->
    <div class="row">
      <div class="col-md-12">
        <h3>Cars List</h3>
        <ul class="list-group">
          <li v-for="car in filteredCars" :key="car.id" class="list-group-item">
            <strong>{{ car.name }}</strong> - {{ car.model }} ({{ car.year }})
            <span class="badge badge-primary">{{ getManufacturerName(car.manufacturer_id) }}</span>
          </li>
          <li v-if="filteredCars.length === 0" class="list-group-item">No cars found.</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      cars: [],
      manufacturers: [],
      selectedManufacturer: '',
    };
  },
  created() {
    this.fetchCars();
    this.fetchManufacturers();
  },
  computed: {
    filteredCars() {
      if (!this.selectedManufacturer) {
        return this.cars;
      }
      return this.cars.filter(car => car.manufacturer_id == this.selectedManufacturer);
    }
  },
  methods: {
    fetchCars() {
      axios.get('/cars')
        .then(response => {
          this.cars = response.data;
        })
        .catch(error => {
          console.error('Error fetching cars:', error);
        });
    },
    fetchManufacturers() {
      axios.get('/manufacturers')
        .then(response => {
          this.manufacturers = response.data;
        })
        .catch(error => {
          console.error('Error fetching manufacturers:', error);
        });
    },
    getManufacturerName(manufacturerId) {
      const manufacturer = this.manufacturers.find(m => m.id === manufacturerId);
      return manufacturer ? manufacturer.name : 'Unknown';
    },
    filterByManufacturer() {
      // Perform filtering when selected manufacturer changes
    }
  }
};
</script>