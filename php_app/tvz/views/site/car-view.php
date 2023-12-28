<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Информация о технике</title>
</head>

<body>
    <div id="app">
        <h1 class="mb-4">Информация о технике - {{ car.name }}
            <button @click="deleteCar" class="btn btn-sm btn-outline-danger ms-3">Удалить технику</button>
        </h1>
        <div>
            <div>
                <button @click="toggleAddOperatorForm" class="btn btn-sm btn-primary">
                    Добавить оператора
                </button>
                <div v-if="isAddOperatorFormVisible">
                    <label for="operatorSelect" class="me-4">Выберите оператора:</label>
                    <select id="operatorSelect" v-model="selectedOperatorId" class="me-4">
                        <option v-for="operator in allOperators" :key="operator.id" :value="operator.id">
                            {{ operator.name }}
                        </option>
                    </select>
                    <button @click="addOperator" class="btn btn-sm btn-outline-success">
                        Добавить
                    </button>
                    <p v-if="operatorAlreadyAssignedErrorMsg" class="alert alert-danger mt-2">{{
                        operatorAlreadyAssignedErrorMsg }}</p>
                </div>
            </div>
            <p class="mt-2"><strong>Список назначенных операторов:</strong></p>
            <ul>
                <div v-for="operator_car_relation in operator_car_data" :key="operator_car_relation.id"
                    class="row mt-4">
                    <div class="col-3">
                        {{ operator_car_relation.operator.name }}
                    </div>
                    <div class="col-9">

                        <button @click="deleteOperator(operator_car_relation.id)" class="btn btn-sm btn-outline-danger">
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
                    car: {},
                    operator_car_data: [],
                    isAddOperatorFormVisible: false,
                    allOperators: [],
                    selectedOperatorId: null,
                    operatorAlreadyAssignedErrorMsg: null,
                };
            },
            mounted() {
                const carId = this.getCarIdFromUrl();
                this.fetchCar(carId);
                this.fetchOperators(carId);
            },
            methods: {
                getCarIdFromUrl() {
                    const pathSegments = window.location.pathname.split('/');
                    return pathSegments[pathSegments.length - 1];
                },
                fetchCar(carId) {
                    axios.get(`http://localhost/api/v1/cars/${carId}`)
                        .then(response => {
                            this.car = response.data;
                        })
                        .catch(error => {
                            console.error('Ошибка получения данных о машине:', error);
                        });
                },
                fetchOperators(carId) {
                    axios.get(`http://localhost/api/v1/operator-cars?carId=${carId}`)
                        .then(response => {
                            this.operator_car_data = response.data;
                        })
                        .catch(error => {
                            console.error('Ошибка получения данных об операторах:', error);
                        });
                },
                fetchAllOperators() {
                    axios.get(`http://localhost/api/v1/operators`)
                        .then(response => {
                            this.allOperators = response.data;
                        })
                        .catch(error => {
                            console.error('Ошибка получения данных обо всех операторах:', error);
                        });
                },
                deleteOperator(operatorCarId) {
                    axios.delete(`http://localhost/api/v1/operator-cars/${operatorCarId}`)
                        .then(response => {
                            // Обновить данные после удаления оператора
                            this.fetchOperators(this.getCarIdFromUrl());
                        })
                        .catch(error => {
                            console.error('Ошибка удаления оператора:', error);
                        });
                },
                toggleAddOperatorForm() {
                    this.fetchAllOperators();
                    this.isAddOperatorFormVisible = !this.isAddOperatorFormVisible;
                },
                addOperator() {
                    this.operatorAlreadyAssignedErrorMsg = null;
                    const isOperatorAlreadyAssigned = this.operator_car_data.some(
                        relation => relation.operator.id === this.selectedOperatorId
                    );

                    if (isOperatorAlreadyAssigned) {
                        this.operatorAlreadyAssignedErrorMsg = "Оператор уже назначен на эту машину."
                        return;
                    }
                    axios.post(`http://localhost/api/v1/operator-cars`, {
                        operator_id: this.selectedOperatorId,
                        car_id: this.getCarIdFromUrl()
                    })
                        .then(response => {
                            this.fetchOperators(this.getCarIdFromUrl());
                            this.isAddOperatorFormVisible = false;
                            this.selectedOperatorId = null;
                        })
                        .catch(error => {
                            console.error('Ошибка добавления оператора:', error);
                        });
                },
                deleteCar() {
                    const confirmDelete = confirm('Вы уверены, что хотите удалить эту технику?');

                    if (confirmDelete) {
                        axios.delete(`http://localhost/api/v1/cars/${this.getCarIdFromUrl()}`)
                            .then(response => {
                                window.location.href = '/cars';
                            })
                            .catch(error => {
                                console.error('Ошибка удаления машины:', error);
                            });
                    }
                }
            }
        });

        app.mount('#app');
    </script>
</body>

</html>