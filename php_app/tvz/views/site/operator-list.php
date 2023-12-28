<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Операторы</title>
</head>

<body>
    <div id="app">
        <button @click="showAddForm" class="btn btn-sm btn-primary">Добавить оператора</button>

        <div v-if="showForm">
            <div class="mb-3">
                <label for="operatorName" class="form-label">Имя</label>
                <input v-model="newOperatorName" 
                       type="text" 
                       class="form-control" 
                       id="operatorName" 
                       required>
            </div>
            <button @click="saveOperator" class="btn btn-sm btn-outline-success me-2">
                Сохранить
            </button>
        </div>

        <h1>Список операторов</h1>
        <div v-for="operator in operators" :key="operator.id" class="row mt-4">
            <div class="col-3">
                {{ operator.name }}
            </div>
            <div class="col-9">
                <button @click="editOperator(operator.id)"
                    class="btn btn-sm btn-outline-secondary">Редактировать</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@3.3.13/dist/vue.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.6.3/dist/axios.min.js"></script>
    <script>
        const app = Vue.createApp({
            data() {
                return {
                    operators: [],
                    showForm: false,
                };
            },

            mounted() {
                this.fetchCars();
            },

            methods: {
                fetchCars() {
                    axios.get('http://localhost/api/v1/operators')
                        .then(response => {
                            this.operators = response.data;
                        })
                        .catch(error => {
                            console.error('Ошибка получения данных:', error);
                        });
                },

                editOperator(id) {
                    window.location.href = `http://localhost/operators/${id}`;
                },

                showAddForm() {
                    this.showForm = !this.showForm;
                    this.newOperatorName = ""
                },

                saveOperator() {
                    axios.post('http://localhost/api/v1/operators', { name: this.newOperatorName })
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