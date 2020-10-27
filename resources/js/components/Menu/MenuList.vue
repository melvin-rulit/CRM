<template>
    <div>

        <hr class="navbar-divider my-3">

        <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
                <router-link to="/" class="nav-link"><i class="fe fe-home"></i>На главную</router-link>
<!--                <a class="nav-link" href="/">-->
<!--                    <i class="fe fe-git-branch"></i>На главную-->
<!--                </a>-->
            </li>

            <li class="nav-item">
                <router-link to="/useraccess" class="nav-link"><i class="fe fe-git-branch"></i>Доступ должностей</router-link>
<!--                <a href="/useraccess" class="nav-link">-->
<!--                    <i class="fe fe-git-branch"></i>Доступ должностей-->
<!--                </a>-->
            </li>

            <li class="nav-item">
                <router-link to="/permissions" class="nav-link"><i class="fe fe-database"></i> Разрешения</router-link>
<!--                <a class="nav-link" href="/permissions">-->
<!--                    <i class="fe fe-database"></i> Разрешения-->
<!--                </a>-->
            </li>

            <li class="nav-item">
                <router-link to="/roles" class="nav-link"><i class="fe fe-git-branch"></i>Должности</router-link>
<!--                <a class="nav-link" href="/roles">-->
<!--                    <i class="fe fe-git-branch"></i>Должности-->
<!--                </a>-->
            </li>

            <li class="nav-item">
                <router-link to="/users" class="nav-link"><i class="fe fe-user"></i>Сотрудники</router-link>
<!--                <a href="/users" class="nav-link">-->
<!--                    <i class="fe fe-user"></i>Сотрудники-->
<!--                </a>-->
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
<!--                            <a href="kassa" class="nav-link ">-->
<!--                                <i class="fe fe-git-branch"></i> Операции-->
<!--                            </a>-->
                        </li>
                        <li class="nav-item">
                            <router-link to="/kassa_setings" class="nav-link"><i class="fe fe-git-branch"></i> Настройки</router-link>
<!--                            <a href="kassa_setings" class="nav-link active">-->
<!--                                <i class="fe fe-git-branch"></i> Настройки-->
<!--                            </a>-->
                        </li>
                    </ul>
                </div>
            </li>



            <li class="nav-item">
                <a class="nav-link" href="/">
                    <i class="fe fe-git-branch"></i> Склад
                </a>
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
<!--                <a class="nav-link" href="/base">-->
<!--                    <i class="fe fe-database"></i> База-->
<!--                </a>-->
            </li>
            <li class="nav-item">
                <router-link to="/journal" class="nav-link"><i class="fe fe-database"></i> Журнал</router-link>
<!--                <a class="nav-link" href="/journal">-->
<!--                    <i class="fe fe-database"></i> Журнал-->
<!--                </a>-->
            </li>
            <li class="nav-item">
                <router-link to="/agregator" class="nav-link"><i class="fe fe-database"></i> Агрегатор лидов</router-link>
<!--                <a class="nav-link" href="/agregator">-->
<!--                    <i class="fe fe-database"></i> Агрегатор лидов-->
<!--                </a>-->
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
                <a class="nav-link" href="#">
                    <i class="fe fe-clipboard"></i>Справочники
                </a>
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
