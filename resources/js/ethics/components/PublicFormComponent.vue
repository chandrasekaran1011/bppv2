<template>
<div>
    <div class="title grad text-center pa-3 ">Part -A</div>

    <v-row :justify="'center'" class="mt-2 py-2  px-4" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields" for="name">Public Client Name</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-text-field label="Public Client Name" :error-messages="nameErrors" @input="$v.name.$touch()" @blur="$v.name.$touch()" name="name" id="name" v-model="name"></v-text-field>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class=" px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left" for="name">Position</div>
        </v-col>
        <v-col cols="12" :md="6">
            <div class="red--text font-weight-bold">{{data.partnerType.name}}</div>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class="px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields" for="name">Business Partner Country</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-autocomplete v-model="partnerCountry" :items="data.countryList" :error-messages="partnerCountryErrors" @input="$v.partnerCountry.$touch()" @blur="$v.partnerCountry.$touch()" item-text="name" item-value="unique" label="Business Partner Country" placeholder="Start typing to Search" prepend-icon="fas fa-flag"></v-autocomplete>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class="  px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 mt-2 text-left reqFields" for="name">Country Score</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-text-field label="Partner Country CPI Score" name="cpi" :error-messages="cpiErrors" @input="$v.cpi.$touch()" @blur="$v.cpi.$touch()" v-model="cpi"></v-text-field>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class="px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields" for="name">SYSTRA’s Group Contract concerned</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-autocomplete v-model="entity" :items="data.entityList" item-text="name" item-value="unique" :error-messages="entityErrors" @input="$v.entity.$touch()" @blur="$v.entity.$touch()" label="Entity" placeholder="Start typing to Search"></v-autocomplete>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class="mt-2  px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields" for="name">CDO</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-radio-group v-model="cdo" row :error-messages="cdoErrors" @change="$v.cdo.$touch()" @blur="$v.cdo.$touch()">
                <v-radio label="Yes" value="1"></v-radio>
                <v-radio label="No" value="0"></v-radio>
            </v-radio-group>
            <!-- <v-checkbox v-model="cdo" true-value="1" false-value="0" :error-messages="cdoErrors" @input="$v.cdo.$touch()" @blur="$v.cdo.$touch()" label="Yes" color="success" hide-details></v-checkbox> -->
        </v-col>
    </v-row>

    <v-row :justify="'center'" v-if="cdo==1" class="mt-2  px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left" for="name">CDO Date</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-menu v-model="datepicker2" :close-on-content-click="false" transition="scale-transition" offset-y max-width="290px" min-width="290px">
                <template v-slot:activator="{ on, attrs }">
                    <v-text-field v-model="cdo_date" label="CDO Date" :error-messages="cdo_dateErrors" @input="$v.cdo_date.$touch()" @blur="$v.cdo_date.$touch()" placeholder="click to select date" persistent-hint prepend-icon="fa fa-calendar" readonly v-on="on" v-bind="attrs"></v-text-field>
                </template>
                <v-date-picker v-model="cdo_date" no-title :min="nowDate" @input="datepicker2 = false"></v-date-picker>
            </v-menu>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class="mt-2 px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left" for="name">Project/Contract Concern </div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-text-field label="Project/Contract Concern" :error-messages="contractErrors" @input="$v.contract.$touch()" @blur="$v.contract.$touch()" name="contract" v-model="contract"></v-text-field>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class="mt-2 px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left mt-2" for="name">Contract phase </div>
        </v-col>
        <v-col cols="12" :md="6">

            <v-select v-model="phase" :items="phaseList" item-text="name" item-value="id" label="Contract Phase" :error-messages="phaseErrors" @input="$v.phase.$touch()" @blur="$v.phase.$touch()"></v-select>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class="px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields" for="name">Project's Country</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-autocomplete v-model="projectCountry" :items="data.countryList" item-text="name" :error-messages="projectCountryErrors" @input="$v.projectCountry.$touch()" @blur="$v.projectCountry.$touch()" item-value="unique" label="Country of the Project" placeholder="Start typing to Search" prepend-icon="fas fa-flag"></v-autocomplete>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class="mt-2  px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields" for="name">Project's Country CPI Score</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-text-field label="CPI Score" name="pcpi" :error-messages="pcpiErrors" @input="$v.pcpi.$touch()" @blur="$v.pcpi.$touch()" v-model="pcpi"></v-text-field>
        </v-col>
    </v-row>

    <!-- <v-row :justify="'center'" class="mt-2  px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields mt-3" for="name">Method of selection of the Business Partner</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-radio-group v-model="mutual" :error-messages="mutualErrors" @input="$v.mutual.$touch()" @blur="$v.mutual.$touch()" row>
                <v-radio label="Mutual Agreement" value="1"></v-radio>
                <v-radio label="Competiton" value="0"></v-radio>
            </v-radio-group>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class="mt-2  px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields mt-3" for="name">Has the Business Partner been recommended by client?</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-radio-group v-model="recomm" :error-messages="recommErrors" @input="$v.recomm.$touch()" @blur="$v.recomm.$touch()" row>
                <v-radio label="Yes" color="red" value="1"></v-radio>
                <v-radio label="No" color="success" value="0"></v-radio>
            </v-radio-group>
        </v-col>
    </v-row> -->

    <div class="title grad text-center pa-3 "> Part-B</div>

    <v-row :justify="'center'" class="px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields" for="name">Registered Address</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-textarea outlined label="Address" name="address" :error-messages="addressErrors" @input="$v.address.$touch()" @blur="$v.address.$touch()" v-model="address" hint="Full Address of the Partner"></v-textarea>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class="mt-2  px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left" for="name">Incorporation number</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-text-field label="Incorporation number" name="cop_num" v-model="cop_num"></v-text-field>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class="mt-2  px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left" for="name">Date of incorporation</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-menu v-model="datepicker" :close-on-content-click="false" transition="scale-transition" offset-y max-width="290px" min-width="290px">
                <template v-slot:activator="{ on, attrs }">
                    <v-text-field v-model="doi" label="Date of Incorporation" placeholder="click to select date" persistent-hint prepend-icon="fa fa-calendar" readonly v-on="on" v-bind="attrs"></v-text-field>
                </template>
                <v-date-picker v-model="doi" no-title :max="nowDate" @input="datepicker = false"></v-date-picker>
            </v-menu>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class="mt-2  px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left" for="name">Jurisdiction of incorporation</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-text-field label="Jurisdiction of incorporation" name="cop_juri" v-model="cop_juri"></v-text-field>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class="mt-2  px-4 py-2" no-gutters>
        <v-col cols="12" :md="6" style="margin-top:16px;">
            <div class="title1 text-left" for="name">Listed in stock exchange</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-checkbox v-model="stock" label="Yes" color="success" :error-messages="stockErrors" @input="$v.stock.$touch()" @blur="$v.stock.$touch()" true-value="1" false-value="0" hide-details></v-checkbox>
        </v-col>
    </v-row>

    <v-row :justify="'center'" v-if="stock==1" class="mt-2  px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields" for="name">Stock Exchange Listed</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-text-field label="Stock Exchange" hint="BSE,NYSE etc.,." name="stock_name" :error-messages="stock_nameErrors" @input="$v.stock_name.$touch()" @blur="$v.stock_name.$touch()" v-model="stock_name"></v-text-field>
        </v-col>
    </v-row>

    <v-row :justify="'center'" v-if="stock==1" class="px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields" for="name">Direct shareholders</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-textarea outlined label="Direct shareholders" name="stock_detail" id="stock_detail" :error-messages="stock_detailErrors" @input="$v.stock_detail.$touch()" @blur="$v.stock_detail.$touch()" v-model="stock_detail"></v-textarea>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class="px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields" for="name">Names of main directors</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-textarea outlined label="Names of Directors and Senior Management" name="director" id="director" :error-messages="directorErrors" @input="$v.director.$touch()" @blur="$v.director.$touch()" v-model="director"></v-textarea>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class="px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields" for="name">Please identify any main affiliated companies:<br>(separated by comma)</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-textarea outlined label="Affiliated companies" name="company" id="company" :error-messages="companyErrors" @input="$v.company.$touch()" @blur="$v.company.$touch()" v-model="company"></v-textarea>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class="mt-2 px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields" for="name">Number of Employees <br> (Minimum:2)</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-text-field label="Number of Employees" type="number" name="employee" :error-messages="employeeErrors" @input="$v.employee.$touch()" @blur="$v.employee.$touch()" v-model="employee"></v-text-field>
        </v-col>
    </v-row>

    <!-- <div class="title grad text-left pa-3 ">Bid Manager CheckPoints</div> -->

    <!-- <v-row :justify="'center'" class="px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields" for="name">Scope of work</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-textarea outlined label="Scope of work" name="scope" id="scope" :error-messages="scopeErrors" @input="$v.scope.$touch()" @blur="$v.scope.$touch()" v-model="scope"></v-textarea>
        </v-col>
    </v-row> -->

    <v-row :justify="'center'" class="mt-2  px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields mt-3" for="name">Has a basic integrity review of the Business Partner by way of an internet search been performed according to the Procedure ?</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-radio-group v-model="search" :error-messages="searchErrors" @input="$v.search.$touch()" @blur="$v.search.$touch()" row>
                <v-radio label="Yes" color="red" value="1"></v-radio>
                <v-radio label="No" color="success" value="0"></v-radio>
                <v-radio label="n.a. (according to procedure cf.3.1)" color="success" value="2"></v-radio>
            </v-radio-group>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class=" px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields  mt-3" for="name"> Attach Relevent Screenshot (optional ,PDF only)</div>
        </v-col>
        <v-col cols="12" :md="6" class="pl-md-3">
            <v-file-input :rules="rules" v-model="screenshot_file" accept=".pdf" placeholder="Attach Screenshot" prepend-icon="fas fa-file" label="Screenshot Document"></v-file-input>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class="mt-2  px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields mt-3" for="name">Does the Public Client have policies and a programme to ensure ethical business practices and prevent corruption?</div>
        </v-col>
        <v-col cols="12" :md="6" class="pl-md-3">
            <v-radio-group v-model="policy" :error-messages="policyErrors" @input="$v.policy.$touch()" @blur="$v.policy.$touch()" row>
                <v-radio label="Yes" color="success" value="1"></v-radio>
                <v-radio label="No" color="red" value="0"></v-radio>
                <v-radio label="No Info Found" color="red" value="2"></v-radio>

            </v-radio-group>
        </v-col>
    </v-row>

    <v-row :justify="'center'" v-if="policy==1" class="mt-2  px-4 py-2 ml-2" no-gutters>
        <v-col cols="12" :md="12">
            <div class="title1 text-left reqFields mt-3" for="name">Does the Policy / Program contain the following -</div>
        </v-col>
        <v-col cols="12" :md="12" class="pl-md-3">

            <v-row :justify="'center'" class="  px-4 py-2" no-gutters>
                <v-col cols="12" :md="6">
                    <div class="title1 text-left reqFields mt-3" for="name"> A code of ethics ?</div>
                </v-col>
                <v-col cols="12" :md="6" class="pl-md-3">
                    <v-radio-group v-model="p1" :error-messages="p1Errors" @input="$v.p1.$touch()" @blur="$v.p1.$touch()" row>
                        <v-radio label="Yes" color="success" value="1"></v-radio>
                        <v-radio label="No" color="red" value="0"></v-radio>
                        <v-radio label="No Info Found" color="red" value="2"></v-radio>

                    </v-radio-group>
                </v-col>
            </v-row>

            <v-row :justify="'center'" class="  px-4 py-2" no-gutters>
                <v-col cols="12" :md="6">
                    <div class="title1 text-left reqFields mt-3" for="name">Ethics and compliance training ?</div>
                </v-col>
                <v-col cols="12" :md="6" class="pl-md-3">
                    <v-radio-group v-model="p2" :error-messages="p2Errors" @input="$v.p2.$touch()" @blur="$v.p2.$touch()" row>
                        <v-radio label="Yes" color="success" value="1"></v-radio>
                        <v-radio label="No" color="red" value="0"></v-radio>
                        <v-radio label="No Info Found" color="red" value="2"></v-radio>

                    </v-radio-group>
                </v-col>
            </v-row>

            <v-row :justify="'center'" class="  px-4 py-2" no-gutters>
                <v-col cols="12" :md="6">
                    <div class="title1 text-left reqFields mt-3" for="name"> A compliance officer ?</div>
                </v-col>
                <v-col cols="12" :md="6" class="pl-md-3">
                    <v-radio-group v-model="p3" :error-messages="p3Errors" @input="$v.p3.$touch()" @blur="$v.p3.$touch()" row>
                        <v-radio label="Yes" color="success" value="1"></v-radio>
                        <v-radio label="No" color="red" value="0"></v-radio>
                        <v-radio label="No Info Found" color="red" value="2"></v-radio>

                    </v-radio-group>
                </v-col>
            </v-row>

            <v-row :justify="'center'" class="  px-4 py-2" no-gutters>
                <v-col cols="12" :md="6">
                    <div class="title1 text-left reqFields mt-3" for="name">A “whistleblowing” process?</div>
                </v-col>
                <v-col cols="12" :md="6" class="pl-md-3">
                    <v-radio-group v-model="p4" :error-messages="p4Errors" @input="$v.p4.$touch()" @blur="$v.p4.$touch()" row>
                        <v-radio label="Yes" color="success" value="1"></v-radio>
                        <v-radio label="No" color="red" value="0"></v-radio>
                        <v-radio label="No Info Found" color="red" value="2"></v-radio>

                    </v-radio-group>
                </v-col>
            </v-row>

            <v-row :justify="'center'" class="mt-2  px-4 py-2" no-gutters>
                <v-col cols="12" :md="6">
                    <div class="title1 text-left reqFields mt-3" :error-messages="p5Errors" @input="$v.p5.$touch()" @blur="$v.p5.$touch()" for="name"> A policy regarding international sanctions ?</div>
                </v-col>
                <v-col cols="12" :md="6" class="pl-md-3">
                    <v-radio-group v-model="p5" row>
                        <v-radio label="Yes" color="success" value="1"></v-radio>
                        <v-radio label="No" color="red" value="0"></v-radio>
                        <v-radio label="No Info Found" color="red" value="2"></v-radio>

                    </v-radio-group>
                </v-col>
            </v-row>

            <v-row :justify="'center'" class=" px-4 py-2" no-gutters>
                <v-col cols="12" :md="6">
                    <div class="title1 text-left reqFields  mt-3" for="name"> Attach Relevant Policy Document</div>
                </v-col>
                <v-col cols="12" :md="6" class="pl-md-3">
                    <v-file-input :rules="rules" v-model="policy_file" accept=".pdf" placeholder="Attach Policy Document" prepend-icon="fas fa-file" label="Policy Document"></v-file-input>
                </v-col>
            </v-row>

        </v-col>
    </v-row>

    <v-row :justify="'center'" class="mt-2  px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields mt-3" for="name">Has the Public Client or its Directors been condemned for non-ethical practices or investigation is in progress ?</div>
        </v-col>
        <v-col cols="12" :md="6" class="pl-md-3">
            <v-radio-group v-model="practice" :error-messages="practiceErrors" @input="$v.practice.$touch()" @blur="$v.practice.$touch()" row>
                <v-radio label="Yes" color="red" value="1"></v-radio>
                <v-radio label="No" color="success" value="0"></v-radio>

            </v-radio-group>
        </v-col>
    </v-row>

    <v-row :justify="'center'" v-if="practice==1" class="px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields" for="name">Provide more information</div>
        </v-col>
        <v-col cols="12" :md="6">
            <v-textarea outlined label="Information on non ethical practices" :error-messages="practice_detailErrors" @input="$v.practice_detail.$touch()" @blur="$v.practice_detail.$touch()" v-model="practice_detail"></v-textarea>
        </v-col>
    </v-row>

    <div class="title grad text-left pa-3 ">Red Flags</div>
    <v-row :justify="'center'" class="mt-2  px-4 py-2" no-gutters>

        <v-col cols="12" :md="6" class="pl-md-3">
            <v-autocomplete multiple v-model="selectedflags" :items="data.flags" label="PreListed Red Flags"></v-autocomplete>
        </v-col>
        <v-col cols="12" :md="6" class="pl-md-3">
            <v-textarea outlined label="Other Red Flags" v-model="otherflags"></v-textarea>
        </v-col>
        <v-col cols="12" :md="12" class="pl-md-3">

            <v-textarea outlined label="Identified Red Flags" :readonly="true" :error-messages="redflagsErrors" @input="$v.redflags.$touch()" @blur="$v.redflags.$touch()" v-model="redflags"></v-textarea>

        </v-col>
    </v-row>

    <div class="title grad text-left pa-3 ">Mitigation Action</div>
    <v-row :justify="'center'" class="mt-2  px-4 py-2" no-gutters>

        <v-col cols="12" :md="6" class="pl-md-3">
            <v-autocomplete multiple v-model="selectedmiti" :items="data.mitigations" label="PreListed Mitigation Action"></v-autocomplete>
        </v-col>
        <v-col cols="12" :md="6" class="pl-md-3">
            <v-textarea outlined label="Other Mitigation Actions" v-model="othermiti"></v-textarea>
        </v-col>
        <v-col cols="12" :md="12" class="pl-md-3">
            <v-textarea outlined label="Identified Mitigation Actions" :readonly="true" :error-messages="mitigationsErrors" @input="$v.mitigations.$touch()" @blur="$v.mitigations.$touch()" v-model="mitigations"></v-textarea>
        </v-col>
    </v-row>

    <div class="title grad text-left pa-3 ">Approval</div>
    <v-row :justify="'center'" class="mt-2  px-4 py-2" no-gutters>
        <v-col cols="12" :md="6">
            <div class="title1 text-left reqFields mt-3" for="name">Name of Compliance Approval Manager:</div>
        </v-col>
        <v-col cols="12" :md="6" class="pl-md-3">
            <v-autocomplete v-model="approver" :error-messages="approverErrors" @input="$v.approver.$touch()" @blur="$v.approver.$touch()" :items="data.approverList" item-text="name" item-value="unique" label="Compliance Approval Manager" placeholder="Start typing to Search" prepend-icon="fas fa-user"></v-autocomplete>
        </v-col>
    </v-row>

    <v-row :justify="'center'" class="mt-2 mb-4  px-4 py-2" no-gutters>
        <v-btn :disabled="$v.$invalid" @click="sumform()" color="success">Create Business Partner</v-btn>

    </v-row>

</div>
</template>

<style>
.grad {
    color: white;
    background-color: rgb(222, 51, 20);
    /* background-image: linear-gradient(315deg, rgb(222, 51, 20) 0%, #b91372 74%); */
}

.pad {
    padding-top: 12px;
}

.reqFields::after {
    content: "*";
    color: red;
}

.v-list-item__title {
    text-align: left;
}
</style>

<script>
import axios from "../axios/axios";
import {
    required,
    integer,
    maxLength,
    requiredIf,
    requiredUnless

} from 'vuelidate/lib/validators';

export default {
    data: () => ({
        rules: [
            value => !value || value.size < 20000000 || 'File size should be less than 20 MB!',
        ],
        phaseList: [{
                name: 'Bid',
                id: 1
            }, {
                name: 'Project',
                id: 2
            },
            {
                name: 'Miscellaneous',
                id: 3
            }],
        nowDate: new Date().toISOString().slice(0, 10),
        datepicker: false,
        datepicker2: false,

        name: '',
        address: '',
        partnerCountry: '',
        cpi: '',
        cop_num: '',
        cop_juri: '',
        doi: '',
        stock: 0,
        stock_name: '',
        stock_detail: '',
        director: '',
        company: '',
        employee: '',

        scope: '',
        entity: '',
        contract: '',
        phase: '',
        projectCountry: '',
        pcpi: '',

        cdo: '0',
        cdo_date: '',
        mutual: '0',
        recomm: '0',
        search: '1',
        screenshot_file: null,
        policy: '0',
        p1: '0',
        p2: '0',
        p3: '0',
        p4: '0',
        p5: '0',
        policy_file: null,
        practice: '0',
        practice_detail: '',

        selectedflags: [],
        otherflags: '',
        redflags: '',

        selectedmiti: [],
        othermiti: '',
        mitigations: '',

        approver: '',

    }),
    props: {
        data: {
            required: true,
            type: Object
        }
    },
    methods: {
        log() {
            console.log(this.$v);
        },
        sumform() {
            if (this.$store.state.loading == true) return;
            this.$store.state.loading = true;
            let formData = new FormData();
            formData.append('_token', document.getElementById('csrf').content);
            formData.append('type_id', this.$route.params.id);
            formData.append('name', this.name)
            formData.append('address', this.address)
            formData.append('country', this.partnerCountry)
            formData.append('cpi', this.cpi)
            formData.append('cop_num', this.cop_num)
            formData.append('cop_juri', this.cop_juri)
            formData.append('doi', this.doi)
            formData.append('stock', this.stock)
            formData.append('stock_name', this.stock_name)
            formData.append('stock_detail', this.stock_detail)
            formData.append('director', this.director)
            formData.append('subsidiary', this.company)
            formData.append('employee', this.employee)
            // formData.append('scope', this.scope)
            formData.append('project_id', this.entity)
            formData.append('contract', this.contract)
            formData.append('phase', this.phase)
            formData.append('pcountry', this.projectCountry)
            formData.append('pcpi', this.pcpi)
            formData.append('cdo', this.cdo)
            formData.append('dcdo', this.cdo_date)
            // formData.append('mutual', this.mutual)
            // formData.append('recomm', this.recomm)
            formData.append('search', this.search)
            formData.append('policy', this.policy)
            formData.append('p1', this.p1)
            formData.append('p2', this.p2)
            formData.append('p3', this.p3)
            formData.append('p4', this.p4)
            formData.append('p5', this.p5)

            formData.append('practice', this.practice)
            formData.append('practice_detail', this.practice_detail)
            formData.append('flag', this.redflags)
            formData.append('mitigations', this.mitigations)
            formData.append('ims_assign', this.approver)

            formData.append('policy_file', this.policy_file)
            formData.append('screenshot_file', this.screenshot_file)

            axios.post(window.links.storePublicForm, formData, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            }).then((resp) => {
                this.$store.commit('snackNotify', {
                    type: 'success',
                    msg: resp.data.message
                });

            }).catch((err) => {
                let errText = '';
                if (err.response.status) {
                    if (err.response.status = 422) {
                        Object.values(err.response.data.errors).forEach(val => {
                            errText += val + '\n';
                        });
                        this.$store.commit('snackNotify', {
                            type: 'error',
                            msg: errText
                        });
                    } else {
                        console.log(err.response);
                        this.$store.commit('snackNotify', {
                            type: 'error',
                            msg: err.response.data.message
                        });

                    }
                }
            }).then(() => {
                this.$store.state.loading = false;
            })

        }

    },
    watch: {
        partnerCountry: function (val) {
            let arr = this.data.countryList;

            arr.forEach((item, index) => {

                if (item.unique == val) {
                    this.cpi = item.cpi
                }
            })
        },
        projectCountry: function (val) {
            let arr = this.data.countryList;

            arr.forEach((item, index) => {

                if (item.unique == val) {
                    this.pcpi = item.cpi
                }
            })
        },
        policy: function (val) {
            if (val == '0') {
                this.p1 = '0';
                this.p2 = '0';
                this.p3 = '0';
                this.p4 = '0';
                this.p5 = '0';
                this.policy_file = '';

            } else if (val == '2') {
                this.p1 = '2';
                this.p2 = '2';
                this.p3 = '2';
                this.p4 = '2';
                this.p5 = '2';
                this.policy_file = '';
            } else {
                this.p1 = '1';
                this.p2 = '1';
                this.p3 = '1';
                this.p4 = '1';
                this.p5 = '1';
                this.policy_file = '';
            }
        },
        selectedflags: function (val) {
            this.redflags = val.join('\n') + '\n' + this.otherflags;
        },
        otherflags: function (val) {
            this.redflags = val + '\n' + this.selectedflags.join('\n');
        },
        selectedmiti: function (val) {
            this.mitigations = val.join('\n') + '\n' + this.othermiti;
        },
        othermiti: function (val) {
            this.mitigations = val + '\n' + this.selectedmiti.join('\n');
        },
        cdo: function (val) {
            if (val == '0') {
                this.cdo_date = '';
            }
        },
        stock: function (val) {
            if (val == '0') {
                this.stock_name = '';
                this.stock_detail = '';
            }
        }

    },
    created() {

    },
    validations: {
        name: {
            required
        },
        address: {
            required
        },
        partnerCountry: {
            required,
            integer
        },
        cpi: {
            required,
            integer
        },
        stock: {
            required
        },
        stock_name: {
            required: requiredIf(function () {
                return this.stock == '1'
            })
        },
        stock_detail: {
            required: requiredIf(function () {
                return this.stock == '1'
            })
        },
        director: {
            required
        },
        company: {
            required
        },
        employee: {
            required,
            integer
        },
        // scope: {
        //     required
        // },
        entity: {
            required
        },
        contract: {
            required
        },
        phase: {
            required
        },
        projectCountry: {
            required,
            integer
        },
        pcpi: {
            required,
            integer
        },
        cdo: {
            required
        },
        cdo_date: {
            required: requiredIf(function () {
                return this.cdo == '1'
            })
        },
        // mutual: {
        //     required
        // },
        // recomm: {
        //     required
        // },
        search: {
            required
        },
        policy: {
            required
        },
        p1: {
            required
        },
        p2: {
            required
        },
        p3: {
            required
        },
        p4: {
            required
        },
        p5: {
            required
        },
        practice: {
            required
        },
        practice_detail: {
            required: requiredIf(function () {
                return this.practice == '1'
            })
        },

        redflags: {
            required
        },
        mitigations: {
            required
        },
        approver: {
            required
        }

    },
    computed: {
        nameErrors() {
            const errors = []
            if (!this.$v.name.$dirty) {
                return errors
            }

            if (!this.$v.name.required) {
                errors.push('Partner name is required.')
            }

            return errors
        },
        addressErrors() {
            const errors = []
            if (!this.$v.address.$dirty) {
                return errors
            }

            if (!this.$v.address.required) {
                errors.push('Partner Address is required.')
            }

            return errors
        },
        partnerCountryErrors() {
            const errors = []
            if (!this.$v.partnerCountry.$dirty) {
                return errors
            }

            if (!this.$v.partnerCountry.required) {
                errors.push('partner Country is required.')
            }

            if (!this.$v.partnerCountry.integer) {
                errors.push('Something went wrong.')
            }

            return errors
        },
        cpiErrors() {
            const errors = []
            if (!this.$v.cpi.$dirty) {
                return errors
            }

            if (!this.$v.cpi.required) {
                errors.push('Partner Country CPI is required.')
            }

            if (!this.$v.cpi.integer) {
                errors.push('Something went wrong.')
            }

            return errors
        },
        stockErrors() {
            const errors = []
            if (!this.$v.stock.$dirty) {
                return errors
            }

            if (!this.$v.stock.required) {
                errors.push('Stock is required.')
            }
            return errors
            console.log(this.$v.stock_name);
        },
        stock_nameErrors() {
            const errors = []
            if (!this.$v.stock_name.$dirty) {
                return errors
            }

            if (!this.$v.stock_name.required) {
                errors.push('Stock Name is required.')
            }
            return errors
            console.log(this.$v.stock_name);

        },
        stock_detailErrors() {
            const errors = []
            if (!this.$v.stock_detail.$dirty) {
                return errors
            }

            if (!this.$v.stock_detail.required) {
                errors.push('Stock detail is required.')
            }
            return errors
        },
        directorErrors() {

            const errors = []
            if (!this.$v.director.$dirty) {
                return errors
            }

            if (!this.$v.director.required) {
                errors.push('Director Names are required.')
            }

            return errors

        },
        companyErrors() {
            console.log('c3')
            const errors = []
            if (!this.$v.company.$dirty) {
                return errors
            }

            if (!this.$v.company.required) {
                errors.push('Subsidary Companies is required.')
            }
            return errors
        },
        employeeErrors() {
            const errors = []
            if (!this.$v.employee.$dirty) {
                return errors
            }

            if (!this.$v.employee.required) {
                errors.push('No. of employees is required.')
            }

            if (!this.$v.employee.integer) {
                errors.push('Something went wrong.')
            }

            return errors
        },
        // scopeErrors() {
        //     const errors = []
        //     if (!this.$v.scope.$dirty) {
        //         return errors
        //     }

        //     if (!this.$v.scope.required) {
        //         errors.push('Scope of work is required.')
        //     }

        //     return errors
        // },
        entityErrors() {
            const errors = []
            if (!this.$v.entity.$dirty) {
                return errors
            }

            if (!this.$v.entity.required) {
                errors.push('Entity is required.')
            }

            return errors
        },
        contractErrors() {
            const errors = []
            if (!this.$v.contract.$dirty) {
                return errors
            }

            if (!this.$v.contract.required) {
                errors.push('Contract is required.')
            }
            return errors
        },
        phaseErrors() {
            const errors = []
            if (!this.$v.phase.$dirty) {
                return errors
            }

            if (!this.$v.phase.required) {
                errors.push('Phase is required.')
            }

            return errors
        },
        projectCountryErrors() {
            const errors = []
            if (!this.$v.projectCountry.$dirty) {
                return errors
            }

            if (!this.$v.projectCountry.required) {
                errors.push('Project Country is required.')
            }

            if (!this.$v.projectCountry.integer) {
                errors.push('Something went wrong.')
            }

            return errors
        },
        pcpiErrors() {
            const errors = []
            if (!this.$v.pcpi.$dirty) {
                return errors
            }

            if (!this.$v.pcpi.required) {
                errors.push('Project Country CPI is required.')
            }

            if (!this.$v.pcpi.integer) {
                errors.push('Something went wrong.')
            }

            return errors
        },
        cdoErrors() {
            const errors = []
            if (!this.$v.cdo.$dirty) {
                return errors
            }

            if (!this.$v.cdo.required) {
                errors.push('CDO is required.')
            }
            return errors
        },
        cdo_dateErrors() {
            const errors = []
            if (!this.$v.cdo_date.$dirty) {
                return errors
            }

            if (!this.$v.cdo_date.required) {
                errors.push('CDO Date is required.')
            }
            return errors
        },
        // mutualErrors() {
        //     const errors = []
        //     if (!this.$v.mutual.$dirty) {
        //         return errors
        //     }

        //     if (!this.$v.mutual.required) {
        //         errors.push('Field is required.')
        //     }
        //     return errors
        // },
        // recommErrors() {
        //     const errors = []
        //     if (!this.$v.recomm.$dirty) {
        //         return errors
        //     }

        //     if (!this.$v.recomm.required) {
        //         errors.push('Field is required.')
        //     }
        //     return errors
        // },
        searchErrors() {
            const errors = []
            if (!this.$v.search.$dirty) {
                return errors
            }

            if (!this.$v.search.required) {
                errors.push('Field is required.')
            }
            return errors
        },
        policyErrors() {
            const errors = []
            if (!this.$v.policy.$dirty) {
                return errors
            }

            if (!this.$v.policy.required) {
                errors.push('Field is required.')
            }
            return errors
        },
        p1Errors() {
            const errors = []
            if (!this.$v.p1.$dirty) {
                return errors
            }

            if (!this.$v.p1.required) {
                errors.push('Field is required.')
            }
            return errors
        },
        p2Errors() {
            const errors = []
            if (!this.$v.p2.$dirty) {
                return errors
            }

            if (!this.$v.p2.required) {
                errors.push('Field is required.')
            }
            return errors
        },
        p3Errors() {
            const errors = []
            if (!this.$v.p3.$dirty) {
                return errors
            }

            if (!this.$v.p3.required) {
                errors.push('Field is required.')
            }
            return errors
        },
        p4Errors() {
            const errors = []
            if (!this.$v.p4.$dirty) {
                return errors
            }

            if (!this.$v.p4.required) {
                errors.push('Field is required.')
            }
        },
        p5Errors() {
            const errors = []
            if (!this.$v.p5.$dirty) {
                return errors
            }

            if (!this.$v.p5.required) {
                errors.push('Field is required.')
            }
            return errors
        },
        practiceErrors() {
            const errors = []
            if (!this.$v.practice.$dirty) {
                return errors
            }

            if (!this.$v.practice.required) {
                errors.push('Field is required.')
            }
            return errors
        },
        practice_detailErrors() {
            const errors = []
            if (!this.$v.practice_detail.$dirty) {
                return errors
            }

            if (!this.$v.practice_detail.required) {
                errors.push('Field is required.')
            }
            return errors
        },
        redflagsErrors() {
            const errors = []
            if (!this.$v.redflags.$dirty) {
                return errors
            }

            if (!this.$v.redflags.required) {
                errors.push('Field is required.')
            }
            return errors
        },
        mitigationsErrors() {
            const errors = []
            if (!this.$v.mitigations.$dirty) {
                return errors
            }

            if (!this.$v.mitigations.required) {
                errors.push('Field is required.')
            }
            return errors
        },
        approverErrors() {
            const errors = []
            if (!this.$v.approver.$dirty) {
                return errors
            }

            if (!this.$v.approver.required) {
                errors.push('Field is required.')
            }
            return errors
        }

    }
}
</script>
