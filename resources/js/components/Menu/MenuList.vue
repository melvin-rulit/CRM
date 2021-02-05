<template>
    <div>

        <hr class="navbar-divider my-3">

        <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
                <router-link to="/" class="nav-link"><i class="fe fe-home"></i>На главную</router-link>
            </li>

            <li class="nav-item">
                <router-link to="/useraccess" class="nav-link"><i class="fe fe-git-branch"></i>Доступ должностей</router-link>
            </li>

            <li class="nav-item">
                <router-link to="/permissions" class="nav-link"><i class="fe fe-database"></i> Разрешения</router-link>
            </li>

            <li class="nav-item">
                <router-link to="/roles" class="nav-link"><i class="fe fe-git-branch"></i>Должности</router-link>
            </li>

            <li class="nav-item">
                <router-link to="/users" class="nav-link"><i class="fe fe-user"></i>Сотрудники</router-link>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="/">
                    <i class="fe fe-git-branch"></i>Отчеты
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed"
                   href="#kassa"
                   data-toggle="collapse"
                   role="button"
                   aria-expanded="false"
                   aria-controls="sidebarDashboards">
                    <i class="fe fe-dollar-sign"></i>Касса
                </a>
                <div class="collapse" id="kassa" style="">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <router-link to="/kassa" class="nav-link"><i class="fe fe-git-branch"></i> Операции</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/kassa_setings" class="nav-link"><i class="fe fe-git-branch"></i> Настройки</router-link>
                        </li>
                    </ul>
                </div>
            </li>



            <li class="nav-item">
                <router-link to="/warehouse" class="nav-link"><i class="fe fe-git-branch"></i>Склад</router-link>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/">
                    <i class="fe fe-book-open"></i>Уведомления<span class="badge badge-primary ml-auto">12</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fe fe-star"></i> Задачи
                </a>
            </li>
            <li class="nav-item">
                <router-link to="/base" class="nav-link"><i class="fe fe-database"></i> База</router-link>
            </li>
            <li class="nav-item">
                <router-link to="/journal" class="nav-link"><i class="fe fe-database"></i> Журнал</router-link>
            </li>
            <li class="nav-item">
                <router-link to="/agregator" class="nav-link"><i class="fe fe-database"></i> Агрегатор лидов</router-link>
            </li>
        </ul>

        <hr class="navbar-divider my-3">

        <h6 class="navbar-heading">Служебные</h6>

        <ul class="navbar-nav mb-md-4">
            <li class="nav-item">
                <a class="nav-link" href="/settings">
                    <i class="fe fe-settings"></i>Настройки
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed"
                   href="#guide"
                   data-toggle="collapse"
                   role="button"
                   aria-expanded="false"
                   aria-controls="sidebarDashboards">
                    <i class="fe fe-dollar-sign"></i>Справочник
                </a>
                <div class="collapse" id="guide" style="">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <router-link to="/source" class="nav-link"><i class="fe fe-git-branch"></i> Источники</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/warehouse_groups" class="nav-link"><i class="fe fe-git-branch"></i> Склады и позиции</router-link>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>

    </div>
</template>

<script>

    export default {
        data(){
            return {

            }
        },

        methods: {

        }
    }

</script>
