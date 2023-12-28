<!DOCTYPE html>
    <html lang="ru">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Техника</title>
       
    </head>

    <body>
        <div id="app">

            <button @click="showAddForm" class="btn btn-sm btn-primary">Добавить транспорт</button>

            <div v-if="showForm">
                <div class="mb-3">
                    <label for="carName" class="form-label">Наименование</label>
                    <input v-model="newCarName" type="text" class="form-control" id="carName" required>
                </div>
                <button @click="saveCar" class="btn btn-sm btn-outline-success me-2">Сохранить</button>
            </div>

            <h1>Список техники</h1>
            <div v-for="car in cars" :key="car.id" class='row mt-4'>
                <div class="col-3">
                    {{ car.name }}
                </div>
                <div class="col-9">
                    <button @click="editCar(car.id)" class="btn btn-sm btn-outline-secondary">
                        Редактировать
                    </button>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/vue@3.3.13/dist/vue.global.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios@1.6.3/dist/axios.min.js"></script>
        <script>
            const app = Vue.createApp({
                data() {
                    return {
                        cars: [],
                        showForm: false,
                    };
                },
                mounted() {
                    this.fetchCars();
                },
                methods: {
                    fetchCars() {
                        axios.get('http://localhost/api/v1/cars')
                            .then(response => {
                                this.cars = response.data;
                            })
                            .catch(error => {
                                console.error('Ошибка получения данных:', error);
                            });
                    },
                    editCar(id) {
                        window.location.href = `http://localhost/cars/${id}`;
                    },
                    showAddForm() {
                        this.showForm = !this.showForm;
                        this.newCarName = ""
                    },

                    saveCar() {
                        axios.post('http://localhost/api/v1/cars', { name: this.newCarName })
                            .then(response => {
                                this.fetchCars();
                            })
                            .catch(error => {
                                console.error('Ошибка сохранения данных:', error);
                            });
                        this.showForm = false;
                    }
                },
            });

            app.mount('#app');
        </script>
    </body>

    </html>