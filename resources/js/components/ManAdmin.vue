<template>
    <div>
      <!-- Add/Edit Manufacturer Form -->
      <div class="card mt-3">
        <div class="card-header">
          {{ editMode ? 'Edit Manufacturer' : 'Add Manufacturer' }}
        </div>
        <div class="card-body">
          <form @submit.prevent="editMode ? updateManufacturer() : addManufacturer()">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" v-model="formData.name" required>
            </div>
            <button type="submit" class="btn btn-primary">{{ editMode ? 'Update Manufacturer' : 'Add Manufacturer' }}</button>
            <button v-if="editMode" @click="cancelEdit" type="button" class="btn btn-secondary ml-2">Cancel</button>
          </form>
        </div>
      </div>
  
      <!-- Manufacturer List -->
      <div class="card mt-3">
        <div class="card-header">
          Manufacturers
        </div>
        <div class="card-body">
          <ul class="list-group">
            <li v-for="manufacturer in manufacturers" :key="manufacturer.id" class="list-group-item d-flex justify-content-between align-items-center">
              {{ manufacturer.name }}
              <div>
                <button @click="editManufacturer(manufacturer)" class="btn btn-info btn-sm mr-2">Edit</button>
                <button @click="deleteManufacturer(manufacturer.id)" class="btn btn-danger btn-sm">Delete</button>
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
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        manufacturers: [],
        formData: {
          name: ''
        },
        editMode: false,
        editedManufacturerId: null,
        message: '',
        messageType: ''
      };
    },
    mounted() {
      this.fetchManufacturers();
    },
    methods: {
      fetchManufacturers() {
        axios.get('/manufacturers')
          .then(response => {
            if(response.data )
            this.manufacturers = response.data;
          })
          .catch(error => {
            console.error('Error fetching manufacturers:', error);
          });
      },
      addManufacturer() {
        axios.post('/manufacturers', this.formData)
          .then(response => {
            this.manufacturers.push(response.data);
            this.clearForm();
            this.showMessage('Manufacturer added successfully.', 'success');
          })
          .catch(error => {
            console.error('Error adding manufacturer:', error);
            this.showMessage('Error adding manufacturer. Please try again.', 'danger');
          });
      },
      editManufacturer(manufacturer) {
        this.formData.name = manufacturer.name;
        this.editMode = true;
        this.editedManufacturerId = manufacturer.id;
      },
      updateManufacturer() {
        axios.put(`/manufacturers/${this.editedManufacturerId}`, this.formData)
          .then(() => {
            this.fetchManufacturers();
            this.clearForm();
            this.showMessage('Manufacturer updated successfully.', 'success');
          })
          .catch(error => {
            console.error('Error updating manufacturer:', error);
            this.showMessage('Error updating manufacturer. Please try again.', 'danger');
          });
      },
      deleteManufacturer(manufacturerId) {
        axios.delete(`/manufacturers/${manufacturerId}`)
          .then(() => {
            this.manufacturers = this.manufacturers.filter(manufacturer => manufacturer.id !== manufacturerId);
            this.showMessage('Manufacturer deleted successfully.', 'success');
          })
          .catch(error => {
            console.error('Error deleting manufacturer:', error);
            this.showMessage('Error deleting manufacturer. Please try again.', 'danger');
          });
      },
      cancelEdit() {
        this.clearForm();
        this.editMode = false;
      },
      clearForm() {
        this.formData.name = '';
        this.editMode = false;
        this.editedManufacturerId = null;
      },
      showMessage(message, type) {
        this.message = message;
        this.messageType = type;
      }
    }
  };
  </script>
  
  <style>
  /* Add custom styles here */
  </style>
  