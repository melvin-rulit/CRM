<template>
    <div>


        <!-- Окно добавления комментария после присвоения статуса не посетил тренировку -->
        <b-modal id="commentModal" title="Введите комментарий" centered ok-title="Добавить" cancel-title="Отмена" @ok="addComent">
            <form ref="form" @submit.stop.prevent="handleSubmit">
                <b-form-group label-for="name-input">
                    <b-form-textarea id="textarea" v-model="comment"></b-form-textarea>
                </b-form-group>
            </form>
        </b-modal>

        <!-- Модальное окно карточки клиента -->
        <b-modal id="userShow" centered hide-footer size="lg" title="Карточка клиента" @hide="closeUserModal">
            <div class="card mb-3">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <input type="file" ref="avatar" @change="onFileChange" style="display: none;">
                        <div v-if="!dataObject.attributes.avatar">
                            <div @click="$refs.avatar.click()" class="hoverim not-photo"><span>?</span></div>
                        </div>
                        <div v-else>
                            <!--                        <img @click="$refs.avatar.click()" class="hoverim photo" :src="siteURL+dataObject.attributes.avatar" />-->
                            <b-img
                                @click="$refs.avatar.click()"
                                center
                                fluid
                                :src="siteURL+dataObject.attributes.avatar"
                                alt="Фото"
                                class="hoverim">
                            </b-img>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-body">
                            <h4 class="pointer">
                                <input-form
                                    v-model="dataObject.attributes.child_surname"
                                    name="child_surname"
                                    @edit-field="editField">
                                </input-form>
                            </h4>
                            <h4 class="pointer">
                                <input-form
                                    v-model="dataObject.attributes.child_name"
                                    name="child_name"
                                    @edit-field="editField">
                                </input-form>
                            </h4>
                            <h4 class="pointer">
                                <input-form
                                    v-model="dataObject.attributes.child_middle_name"
                                    name="child_middle_name"
                                    @edit-field="editField">
                                </input-form>
                            </h4>
                            <!--                        <p data-toggle="tooltip" title="День рождения" class="card-text">-->
                            <p>
                                <!--                            <input-form-->
                                <!--                                v-model="dataObject.attributes.child_birthday"-->
                                <!--                                name="child_birthday"-->
                                <!--                                placeholder="12.05.1988"-->
                                <!--                                v-mask="'##.##.####'"-->
                                <!--                                @edit-field="editField">-->
                                <!--                            </input-form>-->

                                <input-form
                                    v-model="dataObject.attributes.child_birthday"
                                    name="child_birthday"
                                    datePicker="true"
                                    @edit-field="editField">
                                </input-form>

                                <span>({{ dataObject.attributes.age }} лет)</span>
                            </p>
                            <h5>Старый ID: <span class="pointer">
                                        <input-form
                                            v-model="dataObject.attributes.old_id"
                                            name="old_id"
                                            @edit-field="editField">
                                        </input-form>
                                    </span>
                            </h5>

                            <h5 class="text-muted mb-2">Менеджер:
                                <a v-show="!showManager" v-if="dataObject.manager" href="#" @click.prevent="editManager" class="text-dark">{{ dataObject.manager }}</a>
                                <a v-show="showManager" href="#" @click.prevent="editManager">{{dataObject.manager.surname}} {{dataObject.manager.name}}</a>
                            </h5>
                            <select v-show="showManager" @change="saveManager" class="form-control" v-model="dataObject.manager">
                                <option v-for="manager in managers" v-bind:value="manager">{{ manager.surname }} {{ manager.name }}</option>
                            </select>

                            <h5 class="text-muted mb-2">Тренер:
                                <a v-show="!showInstructor" v-if="dataObject.instructor" href="#" @click.prevent="editInstructor" class="text-dark">{{ dataObject.instructor }}</a>
                                <a v-show="showInstructor" href="#" @click.prevent="editInstructor">{{dataObject.instructor.surname}} {{dataObject.instructor.name}}</a>
                            </h5>
                            <select v-show="showInstructor" @change="saveInstructor" class="form-control" v-model="dataObject.instructor">
                                <option v-for="instructor in instructors" v-bind:value="instructor">{{ instructor.surname }} {{ instructor.name }}</option>
                            </select>

                            <h5 class="text-muted mb-2">Программа:
                                <!--                            Возможность редактирования программы-->
                                <!--                            <a v-show="!showProgramm" v-if="dataObject.programm" href="#" @click.prevent="editProgramm" class="text-dark">{{ dataObject.programm }}</a>-->
                                <span v-show="!showProgramm" v-if="dataObject.programm" class="text-dark">{{ dataObject.programm }}</span>

                                <a v-show="showProgramm" href="#" @click.prevent="editProgramm">{{dataObject.programm.name}} {{dataObject.programm.name}}</a>
                            </h5>
                            <select v-show="showProgramm" @change="saveProgramm" class="form-control" v-model="dataObject.programms">
                                <option v-for="programm in programms" v-bind:value="programm">{{ programm.name }}</option>
                            </select>

                            <h5 class="text-muted mb-2">Группа:
                                <span v-if="dataObject.attributes.group" class="text-dark">{{dataObject.attributes.group.name}}</span>
                                <span
                                    v-if="dataObject.attributes.schedule_hall"
                                    v-for="schedule_hall in dataObject.attributes.schedule_hall"
                                    class="text-dark">( {{ getWeekDay(schedule_hall.day) }} - {{ schedule_hall.time }}:00 )</span>
                            </h5>

                            <h6 class="text-uppercase text-muted mb-2 mt-4">
                                <a v-show="!showBranch" href="#" @click.prevent="editBranch">{{dataObject.base_branch}}</a>
                                <a v-show="showBranch" href="#" @click.prevent="editBranch">{{dataObject.base_branch.name}}</a>
                                <a v-if="dataObject.base_branch.name" href="#" @click.prevent="saveBranch" v-show="showBranch" class="fe fe-save h3 text-success"></a>
                            </h6>
                            <select v-show="showBranch" class="form-control" v-model="dataObject.base_branch">
                                <option v-for="branch in branches.branches" v-bind:value="branch">{{ branch.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 border-left">
                        <div class="card-body">
                            <h6 class="text-uppercase text-muted mb-2 text-center">Дата следующего звонка</h6>
                            <date-picker
                                v-model="dataObject.call_date"
                                :editable="false"
                                format="DD.MM.YYYY"
                                value-type="DD.MM.YYYY"
                                class="mb-3"
                                @input="changeCallDate">
                            </date-picker>

                            <select class="form-control mb-3" @change="changeCallStatus($event)">
                                <option v-if="dataObject.call_status == null" value=""></option>
                                <option :selected="dataObject.call_status === 0"" value="0">Не дозвон</option>
                                <option :selected="dataObject.call_status === 1"" value="1">Дозвон</option>
                            </select>

                            <h4 class="text-center mb-3">Статус - <span :style="{ color: dataObject.status_color }">{{ dataObject.status }}</span></h4>

                            <h4 class="text-center mb-1">
                                <a href="#" @click.prevent="showCommentForm">Комментарий</a>
                            </h4>

                            <hr>
                            <h4 class="text-center mb-4">
                                <a href="#" @click.prevent="showUploadForm()"> Документы
                                    <i  class="fe fe-plus text-success pl-3 pointer"></i>
                                </a>
                            </h4>
                            <h5 v-for="documents in dataObject.attributes.documents">
                                <a class="text-muted mb-2" :href="siteURL + documents.path" download>{{ documents.name }}</a>
                            </h5
                            <hr>
                            <!--                                Форма загрузки файла-->
                            <b-form-group v-if="showForm">
                                <b-form-input v-model="uploadFileName" size="sm" class="my-3" placeholder="Название файла"></b-form-input>
                                <div class="input__wrapper">
                                    <input  v-on:change="handleFileUpload()" type="file" ref="file" id="file" class="input input__file" accept=",.jpg,.jpeg,.png,.txt">
                                    <label for="file" class="btn btn-success center btn-sm">
                                        <span class="input__file-button-text">Выберите файл</span>
                                    </label>
                                </div>
                                <button @click="submitFile(dataObject.id)" class="btn btn-primary center btn-sm mt-3">Загрузить</button>
                            </b-form-group>
                        </div>
                    </div>
                </div>
            </div>
            <b-tabs content-class="mt-3">
                <b-tab title="Мать" active>
                    <div class="card-body pb-0 pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <table class=" table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td class="w-25">Фамилия</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.mother_surname"
                                                name="mother_surname"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Имя</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.mother_name"
                                                name="mother_name"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Отчество</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.mother_middle_name"
                                                name="mother_middle_name"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Телефон</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.mother_phone"
                                                name="mother_phone"
                                                placeholder="+38 (926) 123-45-67"
                                                mask="+## (###) ###-##-##"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Телефон</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.mother_dop_phone"
                                                name="mother_dop_phone"
                                                placeholder="+38 (926) 123-45-67"
                                                mask="+## (###) ###-##-##"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Почта</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.mother_email"
                                                name="mother_email"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Viber</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.mother_viber"
                                                name="mother_viber"
                                                placeholder="+38 (926) 123-45-67"
                                                mask="+## (###) ###-##-##"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Telegram</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.mother_telegram"
                                                name="mother_telegram"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Facebook</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.mother_facebook"
                                                name="mother_facebook"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Instagram</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.mother_instagram"
                                                name="mother_instagram"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">ЛПР</td>
                                        <td class="w-75">
                                            <input
                                                @change="sendLpr(dataObject.id, 'mother_lpr')"
                                                type="radio"
                                                id="mother_lpr"
                                                name="mother_lpr"
                                                value="mother_lpr"
                                                v-model="dataObject.attributes.lpr">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Примечания:</label>
                                    <textarea
                                        class="form-control"
                                        v-model="dataObject.attributes.mother_notes"
                                        @blur="event => editField(event, 'mother_notes')"
                                        rows="3">
                                        </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </b-tab>
                <b-tab title="Отец">
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <table class=" table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td class="w-25">Фамилия</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.father_surname"
                                                name="father_surname"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Имя</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.father_name"
                                                name="father_name"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Отчество</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.father_middle_name"
                                                name="father_middle_name"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Телефон</td>
                                        <td class="w-75">
                                            <input-form
                                                placeholder="+38 (926) 123-45-67"
                                                mask="+## (###) ###-##-##"
                                                v-model="dataObject.attributes.father_phone"
                                                name="father_phone"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Телефон</td>
                                        <td class="w-75">
                                            <input-form
                                                placeholder="+38 (926) 123-45-67"
                                                mask="+## (###) ###-##-##"
                                                v-model="dataObject.attributes.father_dop_phone"
                                                name="father_dop_phone"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <td class="w-25">Почта</td>
                                    <td class="w-75">
                                        <input-form
                                            v-model="dataObject.attributes.father_email"
                                            name="father_email"
                                            @edit-field="editField">
                                        </input-form>
                                    </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Viber</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.father_viber"
                                                name="father_viber"
                                                placeholder="+38 (926) 123-45-67"
                                                mask="+## (###) ###-##-##"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Telegram</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.father_telegram"
                                                name="father_telegram"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Facebook</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.father_facebook"
                                                name="father_facebook"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Instagram</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.father_instagram"
                                                name="father_instagram"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">ЛПР</td>
                                        <td class="w-75">
                                            <input @change="sendLpr(dataObject.id, 'father_lpr')" type="radio" id="father_lpr" value="father_lpr" v-model="dataObject.attributes.lpr">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Примечания:</label>
                                    <textarea
                                        class="form-control"
                                        v-model="dataObject.attributes.father_notes"
                                        @blur="event => editField(event, 'father_notes')"
                                        rows="3">
                                        </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </b-tab>
                <b-tab title="Родственник">
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <table class=" table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td class="w-25">Фамилия</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.other_relative_surname"
                                                name="other_relative_surname"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Имя</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.other_relative_name"
                                                name="other_relative_name"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Отчество</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.other_relative_middle_name"
                                                name="other_relative_middle_name"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Телефон</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.other_relative_phone"
                                                name="other_relative_phone"
                                                placeholder="+38 (926) 123-45-67"
                                                mask="+## (###) ###-##-##"
                                                @edit-field="editField"></input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Телефон</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.other_relative_dop_phone"
                                                name="other_relative_dop_phone"
                                                placeholder="+38 (926) 123-45-67"
                                                mask="+## (###) ###-##-##"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    </tr>
                                    <td class="w-25">Почта</td>
                                    <td class="w-75">
                                        <input-form
                                            v-model="dataObject.attributes.other_relative_email"
                                            name="other_relative_email"
                                            @edit-field="editField">
                                        </input-form>
                                    </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Viber</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.other_relative_viber"
                                                name="other_relative_viber"
                                                placeholder="+38 (926) 123-45-67"
                                                mask="+## (###) ###-##-##"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Telegram</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.other_relative_telegram"
                                                name="other_relative_telegram"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Facebook</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.other_relative_facebook"
                                                name="other_relative_facebook"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">Instagram</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.other_relative_instagram"
                                                name="other_relative_instagram"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">р.зв'язок</td>
                                        <td class="w-75">
                                            <input-form
                                                v-model="dataObject.attributes.other_relative_language"
                                                name="other_relative_language"
                                                @edit-field="editField">
                                            </input-form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-25">ЛПР</td>
                                        <td class="w-75">
                                            <input @change="sendLpr(dataObject.id, 'other_relative_lpr')" type="radio" id="other_relative_lpr" value="other_relative_lpr" v-model="dataObject.attributes.lpr">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Примечания:</label>
                                    <textarea
                                        class="form-control"
                                        v-model="dataObject.attributes.other_relative_notes"
                                        @blur="event => editField(event, 'other_relative_notes')"
                                        rows="3">
                                        </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </b-tab>
                <b-tab title="Контракт">
                    <div class="card-body pb-0 pt-3 fix-height">
                        <div class="row">
                            <div class="col-md-6 border-bottom">
                                <div class="row">
                                    <div class="btn-group btn-group-sm mb-3 text-center mx-auto" v-if="dataObject.contracts_active.length > 0">
                                        <button class="btn btn-sm btn-outline-secondary mr-4" @click="indexactiveContract--" :disabled="indexactiveContract <= 0">Предыдущий</button>
                                        <button class="btn btn-sm btn-outline-secondary ml-4" @click="indexactiveContract++" :disabled="indexactiveContract === dataObject.contracts_active.length - 1">Следующий</button>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-6 border-bottom">
                                <div class="row">
                                    <div class="center mb-3">
                                        <button @click="closeModal()" class="btn btn-sm btn-success">Добавить контракт</button>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <transition name="fade" mode="out-in">
                                    <div v-if="dataObject.contracts_active.length > 0" class="table-responsive" :key="indexactiveContract">
                                        <div v-if="activeContract">
                                            <p @click="showContract(activeContract.id)" class="card-text text-center pointer">"{{ activeContract.name }}"</p>
                                            <table class="table table-bordered table-hover datatable datatable-User">
                                                <tbody>
                                                <tr>
                                                    <td>Дата составления:</td>
                                                    <td>{{ activeContract.date }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Начало:</td>
                                                    <td>{{ activeContract.start }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Окончание:</td>
                                                    <td>{{ activeContract.end }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Окончание факт:</td>
                                                    <td>{{ activeContract.end_actually }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Заморозки:</td>
                                                    <td>{{ activeContract.freezing_total }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Тренировки:</td>
                                                    <td>{{ activeContract.classes_total }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <p>Оплаты:
                                                <span v-for="pays in activeContract.pays" data-toggle="tooltip" data-placement="top" :title="pays.date" class="text-muted ml-2 pointer">{{ pays.pay }}</span>
                                            </p>
                                            <p>Сумма и остаток: <span class="ml-2">{{ summPaysActiveContract(activeContract.pays) }} ({{ summPaysActiveContract(activeContract.pays) }})</span>
                                            </p>
                                        </div>
                                    </div>
                                    <p class="text-center font-weight-bold" v-else>Нет активных контрактов</p>
                                </transition>
                            </div>
                            <div class="col-md-6 mt-3">
                                <div class="form-group">
                                    <p class="card-text text-center">Прошлые контракты</p>
                                    <p v-for="contracts_not_active in dataObject.contracts_not_active">
                                        <a @click.prevent="showContract(contracts_not_active.id)" href="#" class="text-muted">"{{contracts_not_active.name}}" &nbsp {{contracts_not_active.start}} - {{contracts_not_active.end_actually}}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </b-tab>
                <b-tab title="История">
                    <div class="card mt-3 fix-height">
                        <div class="card-body">
                            <p v-if="dataObject.comments" v-for="comment in dataObject.comments" :key="comment.id" class="mb-2">
                                {{ comment.date }} - {{ comment.user }} - {{ comment.comment }}
                            </p>
                        </div>
                    </div>
                </b-tab>
                <b-tab title="Интересы">
                    <p class="fix-height"></p>
                </b-tab>
                <b-tab title="Навыки">
                    <p class="fix-height"></p>
                </b-tab>
            </b-tabs>
        </b-modal>

        <dogovor-component :user_id="dataObject.id"></dogovor-component>
        <show-dogovor-component ref="showmodal"></show-dogovor-component>
    </div>
</template>

<script>

    import DatePicker from 'vue2-datepicker';
    Vue.use(DatePicker);
    import 'vue2-datepicker/index.css';

    import Vue from "vue";

    import vueHeadful from 'vue-headful';
    Vue.component('vue-headful', vueHeadful);

    $(document).ready(function() {
        $("body").tooltip({ selector: '[data-toggle=tooltip]' });
    });

    import Avatar from 'vue-avatar'

    import Vuelidate from 'vuelidate'
    Vue.use(Vuelidate)
    import { required, minLength } from 'vuelidate/lib/validators'


    import willvalidate from 'willvalidate'
    Vue.use(willvalidate)

    import VueToast from 'vue-toast-notification';
    import 'vue-toast-notification/dist/theme-sugar.css';
    Vue.use(VueToast);

    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';
    Vue.use(Loading);


    export default {
        props: {
            user_id: {
                type: String,
            },
        },
        data() {
            return{
                comment: '',
                fullPage: true,
                call_date: '',
                call_status: '',
                surname: null,
                birthday: null,
                users: [],
                busy: false,
                branches: {
                    branches: [],
                },
                managers: [],
                instructors: [],
                programms: [],
                users: [],
                name:'',
                qw:'',
                image: '',
                instructor: '',
                dataObject: {
                    attributes: {},
                    contracts_not_active: {},
                    contracts_active: {},
                    base_branch: {},
                    manager: {},
                    instructor: {},
                    programm: {},
                    comments: {},
                },
                indexactiveContract: 0,
                getURL: "api/v2/getinfo",
                postURL: "getone",
                URLaddNewUser: "api/v2/addnewuser",
                siteURL: "http://83.220.172.19/",
                articles: [],
                users: [],
                article_id: '',
                showBranch: false,
                showInstructor: false,
                showManager: false,
                showProgramm: false,
                branch: '',
                filter: false,
                new_child_surname: '',
                new_child_name: '',
                contract: [],
                lpr: '',
                showForm: false,
                uploadFileName: '',
                file: '',
                picked: '',
            }
        },
        validations: {
            new_child_surname: {
                required,
            },
            new_child_name: {
                required,
            }
        },
        created(){
            // this.fetchArticles();
            // axios.post('api/v2/getinfo', {id : this.user_id}).then(response => {
            //     this.dataObject = response.data.data
            // })
        },
        mounted(){
            $('#addNew').on('hide.bs.modal', () => this.closeModalView())
        },

        components:{
            Avatar
        },

        computed: {
            activeContract() {
                return this.dataObject.contracts_active[this.indexactiveContract]
            }
        },

        methods: {

            showModa(id){
                axios.post('api/v2/getinfo', {id : id, set_block : 1}).then(response => {
                    if(response.data.response == "block"){
                        this.$alert(`В данный момент с карточкой работает пользователь ${response.data.user_block_name}`)
                    }else{
                        this.dataObject = response.data.data
                        this.$bvModal.show('userShow')
                    }
                })
            },
            // Получаем сокращеное название дня по дате
            getWeekDay(day) {
                var days = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
                return days[day];
            },

            sendLpr(id, lpr){
                axios.post( 'api/v2/updateLpr/', {id: id, lpr: lpr})
            },

            showUploadForm(){
                this.showForm = true
            },

            submitFile(base_id){
                let formData = new FormData();

                if (!this.uploadFileName || !this.file){
                    Vue.$toast.open({message: 'Не выбран файл или имя пустое' ,type: 'error',duration: 5000,position: 'top-right'});
                    return null
                }

                formData.append('file', this.file);
                console.log(formData)
                axios.post( '/api/v2/documents',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        params: {
                            name: this.uploadFileName,
                            base_id: base_id
                        },
                    }
                )
                this.showForm = false
                this.uploadFileName = ''
                this.file = ''

                Vue.$toast.open({message: 'Файл успешно загружен' ,type: 'success',duration: 5000,position: 'top-right'});

                setTimeout(() => {
                    axios.post('api/v2/getinfo', {id : base_id})
                        .then(response => {
                            this.dataObject = response.data.data
                        })
                }, 200)
            },

            handleFileUpload(){
                this.file = this.$refs.file.files[0];
            },

            summPaysActiveContract(pays){
                let sum = 0
                pays.forEach(function (value, key) {
                    sum += value.pay
                });
                return sum
            },
            showCollapse(){
                this.filter  ? $('#filter').collapse('hide') : $('#filter').collapse('show');
            },
            fetch() {
                this.busy = true;
                axios.get(`api/v2/filter`, {
                    params: {
                        surname: this.surname,
                        name: this.name,
                        birthday: this.birthday,
                    }
                })
                    .then(response => {
                        this.articles = response.data.data;
                        this.busy = false;
                    })
            },
            showContract(id){
                this.$confirm("Показать контракт ?").then(() => {
                    $('#addNew').modal('hide')
                    this.$refs.showmodal.showModal(id)
                });
            },
            getModal(id){
                this.$bvModal.show('userShow')
                axios.post('api/v2/getinfo', {id : id}).then(response => {
                    this.dataObject = response.data.data
                })
            },
            fetchArticles(){
                axios.get('api/v2/collection')
                    .then(response => this.articles = response.data.data)
                    .finally(() => console.log('Посты успешно загружены'));

            },

            getBranches(){
                axios.get('api/v2/getbranches')
                    .then(response => this.branches = response.data.data)
            },

            getManagers(){
                axios.get('api/v2/getmanagers')
                    .then(response => this.managers = response.data.data)
            },

            getInstructors(){
                axios.get('api/v2/getinstructors')
                    .then(response => this.instructors = response.data.data)
            },

            editBranch(){
                this.showBranch = true
                this.getBranches()
            },
            editManager(){
                this.showManager = true
                this.getManagers()
            },
            editInstructor(){
                this.showInstructor = true
                this.getInstructors()
            },
            editProgramm(){
                this.showProgramm = true
                this.getProgramm()
            },
            saveBranch(){
                axios.post(this.postURL, { user_id: this.dataObject.id, field_name: 'branch' , field_value: this.dataObject.base_branch.id })
                this.showBranch = false
                this.dataObject.base_branch = this.dataObject.base_branch.name
            },
            saveManager(){
                axios.post(this.postURL, { user_id: this.dataObject.id, field_name: 'manager' , field_value: this.dataObject.manager.id })
                this.showManager = false
                this.dataObject.manager = this.dataObject.manager.surname + ' ' + this.dataObject.manager.name
            },
            saveInstructor(){
                axios.post(this.postURL, { user_id: this.dataObject.id, field_name: 'instructor' , field_value: this.dataObject.instructor.id })
                this.showInstructor = false
                this.dataObject.instructor = this.dataObject.instructor.surname + ' ' + this.dataObject.instructor.name
            },
            saveProgramm(){
                axios.post(this.postURL, { user_id: this.dataObject.id, field_name: 'programm_id' , field_value: this.dataObject.programms.id })
                this.showProgramm = false
                this.dataObject.programm = this.dataObject.programms.name
            },
            editField(e, name, type) {

                if (type){
                    axios.post(this.postURL, {user_id: this.dataObject.id, field_name: name, field_value: e })

                    // Если мы меняем значение день рождения. то перезагружаем всю карточку, заебали ныть
                    if(name == 'child_birthday'){
                        setTimeout(() => {
                            axios.post('api/v2/getinfo', {id : this.dataObject['id']}).then(response => {
                                this.dataObject = response.data.data
                            })
                        },100)
                    }
                }else{
                    const value = e.target.value;
                    const key = e.currentTarget.getAttribute('name');
                    axios.post(this.postURL, { user_id: this.dataObject.id, field_name: name ? name : key, field_value: value })
                }
            },

            // editField(e, name, type) {
            //     if (type){
            //         axios.put('api/v2/users/' + this.user.id, {field_name: name, field_value: e })
            //     }else{
            //         const value = e.target.value;
            //         const key = e.currentTarget.getAttribute('name');
            //         axios.put('api/v2/users/' + this.user.id, {field_name: key, field_value: value })
            //     }
            // },

            closeModal(){
                // $('#addNew').modal('hide');
                // $('#selectModal').modal('show');
                this.$bvModal.show('selectModal')
                this.$bvModal.hide('userShow')
            },
            BaseModal(){
                this.$bvModal.show('userShow')
            },
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                var image = new Image();
                var reader = new FileReader();
                var vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
                this.upload(event);
            },
            upload(event){
                let data = new FormData();
                let file = event.target.files[0];
                data.append('file', file)
                data.append('id', this.dataObject['id'])
                let config = {
                    header : {
                        'Content-Type' : 'multipart/form-data'
                    }
                }
                axios.post('api/v2/image', data, config)
                setTimeout(() => {
                    axios.post('api/v2/getinfo', {id : this.dataObject['id']}).then(response => {
                        this.dataObject = response.data.data
                    })
                }, 200)
            },
            closeUserModal(bvModalEvt){
                if(!this.dataObject.call_date){
                    bvModalEvt.preventDefault()
                    this.$alert('Ты долбоеб не заполнил дату следующего звонка')
                    return false
                }
                this.removeBlock()
                this.showBranch = false
                this.showManager = false
                this.showInstructor = false
                this.showProgramm = false

                $('#info li:first-child a').tab('show')

                this.dataObject.contracts_active = [];
                this.indexactiveContract = 0
                this.fetchArticles()
                this.showForm = false
                this.call_status = ''
                this.call_date = ''
            },

            removeBlock(){
                axios.post('api/v2/removeblock', {id : this.dataObject['id']})
            },

            changeCallDate(){
                axios.post('api/v2/changeCallDate', {
                    id : this.dataObject['id'],
                    call_date: this.dataObject.call_date
                })
            },

            changeCallStatus(event){
                if (event.target.value){
                    axios.post('api/v2/changeCallStatus', {
                        id : this.dataObject['id'],
                        call_status: event.target.value
                    })
                }
            },

            showCommentForm(){
                this.$bvModal.show('commentModal')
            },

            addComent(){
                if (this.comment){
                    axios.post('api/v2/changeCallStatus', {
                        id : this.dataObject['id'],
                        call_status : 1,
                        comment: this.comment
                    })
                    this.comment = ''

                        axios.post('api/v2/getinfo', {id : this.dataObject['id'], set_block : 0}).then(response => {
                            this.dataObject = response.data.data
                        })
                }else{
                    this.$alert('Коментарий не может быть пустым')
                }
            }
        }
    }
</script>

<style scoped>
    .table td, .table th {
        padding: 10px;
        font-size: 14px;
    }

    .center{
        display: block;
        margin: 0 auto;
    }

    .slide-fade-enter-active {
        transition: all .3s ease;
    }

    .slide-fade-leave-active {
        transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active до версии 2.1.8 */ {
        transform: translateX(10px);
        opacity: 0;
    }

    .toast{
        max-width: 1200px;
    }

    .table-collection tr {
        cursor: pointer;
    }

    .hoverim:hover{
        opacity: 0.5;
        cursor: pointer;
    }

    .not-photo{
        display: flex;
        width: 250px;
        height: 250px;
        border-radius: 0px;
        font: 100px / 250px Helvetica, Arial, sans-serif;
        align-items: center;
        justify-content: center;
        text-align: center;
        user-select: none;
        background-color: rgb(255, 193, 7);
        color: rgb(255, 255, 255);
    }

    .photo{
        display: flex;
        width: 250px;
        height: 250px;
        border-radius: 0px;
    }

    .form-group--error input, .form-group--error textarea, .form-group--error input:focus, .form-group--error input:hover {
        border-color: #f79483;
    }

    .form-group--error + .form-group__message, .form-group--error + .error {
        display: block;
        color: #f57f6c;
    }
    .form-group__message, .error {
        font-size: 0.75rem;
        line-height: 1;
        display: none;
        margin-left: 14px;
        margin-top: -0.687rem;
        margin-bottom: 0.9375rem;
    }
    .result-list {
        max-height: 200px;
        overflow-y: auto;
    }

    .fix-height{
        min-height: 300px;
        max-height: 500px;
        overflow-y: auto;
    }
    .center{
        display: block;
        margin: 0 auto;
    }

    .input__file {
        opacity: 0;
        visibility: hidden;
        position: absolute;
    }

    table {
        width:100%;
        table-layout: fixed;
    }

    .tbl-content {
        height: 800px;
        overflow-x: auto;
        margin-top: 0px;
    }
</style>
