<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оператор</title>
</head>

<body>
    <div id="app">
        <h1 class="mb-4">Оператор - {{ operator.name }}
            <button @click="deleteOperator" class="btn btn-sm btn-outline-danger ms-3">Удалить оператора</button>
        </h1>
        <div>
            <div>
                <button @click="toggleAssignCarForm" class="btn btn-sm btn-primary">Назначить на машину</button>
                <div v-if="isAssignCarFormVisible">
                    <label for="carSelect" class="me-4">Выберите машину:</label>
                    <select id="carSelect" v-model="selectedCarId" class="me-4">
                        <option v-for="car in allCars" :key="car.id" :value="car.id">{{ car.name }}</option>
                    </select>
                    <button @click="assignCar" class="btn btn-sm btn-outline-success">Назначить</button>
                    <p v-if="operatorAlreadyAssignedErrorMsg" class="alert alert-danger mt-2">
                        {{ operatorAlreadyAssignedErrorMsg }}
                    </p>
                </div>
            </div>
            <p class="mt-2"><strong>Список доступных машин оператора:</strong></p>
            <ul>
                <div v-for="operator_car_relation in operator_car_data" :key="operator_car_relation.id"
                    class="row mt-4">
                    <div class="col-3">
                        {{ operator_car_relation.car.name }}
                    </div>
                    <div class="col-9">
                        <button @click="unassignCar(operator_car_relation.id)" class="btn btn-sm btn-outline-danger">
                            Удалить
                        </button>
                    </div>
                </div>
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@3.3.13/dist/vue.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.6.3/dist/axios.min.js"></script>
    <script>
        const app = Vue.createApp({
            data() {
                return {
                    operator: {},
                    operator_car_data: [],
                    isAssignCarFormVisible: false,
                    allCars: [],
                    selectedCarId: null,
                    operatorAlreadyAssignedErrorMsg: null,
                };
            },
            mounted() {
                const operatorId = this.getOperatorIdFromUrl();
                this.fetchOperator(operatorId);
                this.fetchAssignedCars(operatorId);
            },
            methods: {
                getOperatorIdFromUrl() {
                    const pathSegments = window.location.pathname.split('/');
                    return pathSegments[pathSegments.length - 1];
                },
                fetchOperator(operatorId) {
                    axios.get(`http://localhost/api/v1/operators/${operatorId}`)
                        .then(response => {
                            this.operator = response.data;
                        })
                        .catch(error => {
                            console.error('Ошибка получения данных об операторе:', error);
                        });
                },
                fetchAssignedCars(operatorId) {
                    axios.get(`http://localhost/api/v1/operator-cars?operatorId=${operatorId}`)
                        .then(response => {
                            this.operator_car_data = response.data;
                        })
                        .catch(error => {
                            console.error('Ошибка получения данных о назначенных машинах:', error);
                        });
                },
                fetchAllCars() {
                    axios.get(`http://localhost/api/v1/cars`)
                        .then(response => {
                            this.allCars = response.data;
                        })
                        .catch(error => {
                            console.error('Ошибка получения данных обо всех машинах:', error);
                        });
                },
                unassignCar(operatorCarId) {
                    axios.delete(`http://localhost/api/v1/operator-cars/${operatorCarId}`)
                        .then(response => {
                            // Обновить данные после отмены назначения
                            this.fetchAssignedCars(this.getOperatorIdFromUrl());
                        })
                        .catch(error => {
                            console.error('Ошибка отмены назначения машины:', error);
                        });
                },
                toggleAssignCarForm() {
                    this.fetchAllCars();
                    this.isAssignCarFormVisible = !this.isAssignCarFormVisible;
                },
                assignCar() {
                    this.operatorAlreadyAssignedErrorMsg = null;
                    const isOperatorAlreadyAssigned = this.operator_car_data.some(
                        relation => relation.car.id === this.selectedCarId
                    );

                    if (isOperatorAlreadyAssigned) {
                        this.operatorAlreadyAssignedErrorMsg = "Оператор уже назначен на эту машину."
                        return;
                    }

                    axios.post(`http://localhost/api/v1/operator-cars`, {
                        operator_id: this.getOperatorIdFromUrl(),
                        car_id: this.selectedCarId
                    })
                        .then(response => {
                            this.fetchAssignedCars(this.getOperatorIdFromUrl());
                            this.isAssignCarFormVisible = false;
                            this.selectedCarId = null;
                        })
                        .catch(error => {
                            console.error('Ошибка назначения машины:', error);
                        });
                },
                deleteOperator() {
                    const confirmDelete = confirm('Вы уверены, что хотите удалить этого оператора?');

                    if (confirmDelete) {
                        axios.delete(`http://localhost/api/v1/operators/${this.getOperatorIdFromUrl()}`)
                            .then(response => {
                                window.location.href = '/operators';
                            })
                            .catch(error => {
                                console.error('Ошибка удаления оператора:', error);
                            });
                    }
                }
            }
        });

        app.mount('#app');
    </script>
</body>

</html>