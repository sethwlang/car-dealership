<template>
    <!-- Add/Edit Car Form -->
    <div class="card mt-3">
      <div class="card-header">
        {{ editMode ? 'Edit Car' : 'Add Car' }}
      </div>
      <div class="card-body">
        <form @submit.prevent="editMode ? updateCar() : addCar()">
          <div class="form-group">
            <label for="model">Model</label>
            <input type="text" class="form-control" id="model" v-model="formData.model" required>
          </div>
          <div class="form-group">
            <label for="year">Year</label>
            <input type="number" class="form-control" id="year" v-model="formData.year" required>
          </div>
          <div class="form-group">
            <label for="manufacturer">Manufacturer:</label>
    <select class="form-control" v-model="formData.manufacturer_id">
      <option value="">Select Manufacturer</option>
      <option v-for="manufacturer in manufacturers" :key="manufacturer.id" :value="manufacturer.id">{{ manufacturer.name }}</option>
    </select>
          </div>
          <button type="submit" class="btn btn-primary">{{ editMode ? 'Update Car' : 'Add Car' }}</button>
          <button v-if="editMode" @click="cancelEdit" type="button" class="btn btn-secondary ml-2">Cancel</button>
        </form>
      </div>
    </div>

    <!-- Car List -->
    <div class="card mt-3">
      <div class="card-header">
        Cars
      </div>
      <div class="card-body">
        <ul class="list-group">
          <li v-for="car in cars" :key="car.id" class="list-group-item d-flex justify-content-between align-items-center">
            {{ car.model }} - {{ car.year }}
            <div>
              <button @click="editCar(car)" class="btn btn-info btn-sm mr-2">Edit</button>
              <button @click="deleteCar(car.id)" class="btn btn-danger btn-sm">Delete</button>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <!-- Success/Error Message -->
    <div v-if="message" class="mt-3 alert alert-{{ messageType }} alert-dismissible fade show" role="alert">
      {{ message }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      cars: [],
      formData: {
        model: '',
        year: '',
        manufacturer_id: ''
      },
      editMode: false,
      editedCarId: null,
      message: '',
      messageType: '',
      manufacturers: []
      
    };
  },
  mounted() {
    this.fetchCars();
    this.fetchManufacturers();
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
    addCar() {
      axios.post('/cars', this.formData)
        .then(response => {
          this.cars.push(response.data);
          this.clearForm();
          this.showMessage('Car added successfully.', 'success');
        })
        .catch(error => {
          console.error('Error adding car:', error);
          this.showMessage('Error adding car. Please try again.', 'danger');
        });
    },
    editCar(car) {
      this.formData.model = car.model;
      this.formData.year = car.year;
      this.FormData.manId = car.manId;
      this.editMode = true;
      this.editedCarId = car.id;
    },
    updateCar() {
      axios.put(`/cars/${this.editedCarId}`, this.formData)
        .then(() => {
          this.fetchCars();
          this.clearForm();
          this.showMessage('Car updated successfully.', 'success');
        })
        .catch(error => {
          console.error('Error updating car:', error);
          this.showMessage('Error updating car. Please try again.', 'danger');
        });
    },
    deleteCar(carId) {
      axios.delete(`/cars/${carId}`)
        .then(() => {
          this.cars = this.cars.filter(car => car.id !== carId);
          this.showMessage('Car deleted successfully.', 'success');
        })
        .catch(error => {
          console.error('Error deleting car:', error);
          this.showMessage('Error deleting car. Please try again.', 'danger');
        });
    },
    cancelEdit() {
      this.clearForm();
      this.editMode = false;
    },
    clearForm() {
      this.formData.model = '';
      this.formData.year = '';
      this.editMode = false;
      this.editedCarId = null;
    },
    showMessage(message, type) {
      this.message = message;
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
    
  }
}
  </script>