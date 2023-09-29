<?php
/*
 * Plugin Name:       TDEE Calculator
 * Description:       Adds a widget to calculate TDEE for a specific health goal.
 */

 add_shortcode('tdee_calculator', 'sba_tdee_calculator');

 function sba_tdee_calculator($atts) {
   	ob_start();
   	?>
   		<style>
   /* Mobile Styles */
   @media screen and (max-width: 768px){
       #app {
         padding: 0 15px 30px;
      }
   }
   @media screen and (max-width: 425px){
      .options{
         grid-template-columns: 30px auto!important;
      }
      .options i {
         font-size: 30px!important;
      }
      .options h5 {
         font-size: 0.9em;
      }
      .options p {
         font-size: 0.9em;
         line-height: 1.5em;
      }
      .message {
         font-size: 0.9em;
      }
      .calculator {
         column-gap: 5px;
      }
      label.weightInput, label.heightInput {
         max-width: 85vw!important;
      }
      .unit {
         padding: 15px 10vw!important;
      }
      p.result-amount {
         line-height: 1;
      }
      div#results {
         width: 90vw!important;
      }
      .explanation {
         padding: 0px 10px;
         text-align: center;
      }
      .explanation h6 {
         margin: 15px 0px;
      }
      .explanation p {
         font-size: 0.9em;
      }
      span.target-wrapper.protein {
         border-top-right-radius: 40px;
      }
      span.target-wrapper.calories {
         border-top-left-radius: 40px;
      }
      .names, .emailSub {
         flex-direction: column;
         align-items: flex-start;
      }
      .mergeRow, .submit_container {
         width: 100%!important;
      }
      .mergeRow label{
         text-align: left;   
      }
      #mergeTable input {
         margin-bottom: 8px;
      }
      .submit_container {
         margin-top: 8px;
      }
   }
   /* Regular Styles (desktop and tablet) */ 
   #app {
      display: flex;
      align-items: center;
      justify-content: center;
   }
   .choices{
      max-width: 600px;
      display: flex;
      flex-direction: column;
   }
   .options{
      border: 2px solid rgba(0, 82, 142, 0.2);
      border-radius: 10px;
      display: grid;
      grid-template-columns: 70px auto;
      column-gap: 20px;
      align-items:  center;
      margin: 7px 15px;
      padding: 15px;
   }
   .options i {
       font-size: 40px;
       color: var( --e-global-color-primary );
       justify-self: center;
   }
   .options h5{
       margin: 5px 0;
   }
   .options:hover, .options:focus{
      cursor: pointer;
   }
   .selected-option{
      background: linear-gradient(45deg, rgba(0, 82, 142, 0.4), rgb(43, 185, 162, 0.4));
   }
   .next-step{
       margin: 0 15px; 
   }
   .next-step, .do-calculation, .formEmailButton{
      background: linear-gradient(45deg, var(--e-global-color-primary), var(--e-global-color-accent));
      text-transform: uppercase!important;
      font-weight: 600;
      font-size: 14px;
      border-radius: 50px;
   }
   .formEmailButton{
      width: 100%;
   }
   .next-step:hover, .do-calculation:hover{
       background-color: var( --e-global-color-accent );
   }
   .go-back{
       text-align: center;
       grid-column: span 2;
       cursor: pointer;
   }
   .calculator {
      display: none;
      grid-template-columns: auto auto;
      justify-content: space-around;
      row-gap: 10px;
      width: 500px;
      padding: 15px;
   }
   .calculator-title {
      grid-column: span 2;
      text-align: center;
      font-size: 1.5rem;
   }
   label{
      font-size: 14px;
   }
   .calculator label{
      display: flex;
      flex-direction: column;
      max-width: 200px;
   }
   select {
      padding: 8px!important;
   }
   input[type="text"], input[type=email], input[type="number"] {
      padding: 8px!important;
   }
   input:focus, input.range_indicator:focus {
      border-color: var(--e-global-color-primary)!important;
      color: var(--go-input--color--text)!important;
   }
   .unit{
      padding: 20px 60px;
      font-size: 16px;
      font-weight: 600;
      text-align: center;
      border-radius: 10px;
      cursor: pointer;
   }
   #lnameID, #fnameID {
      margin-bottom: 10px;
   }
   .weightInput, .heightInput{
      grid-column: span 2;
      max-width: 500px!important;
   } 
   .range_indicator{
      text-align: right;
      align-self: end;
      width: 65px!important;
      padding: 5px!important;
      margin: 0!important;
   }
   .range_indicator.imperial{
      display: none;
      width: 180px!important;
      padding: 0!important;
      margin-top: -20px!important;
   }
   .range_indicator.imperial > .range_indicator {
      width: 50px!important;
   }
   .range_indicator.metric, .range_indicator.weight{
      margin-top: -20px!important;
   }
   #heightID, #weightID {
      border: none;
      padding-left: 0;
      padding-right: 0;
      margin-bottom: 0;
   }
   input[type=radio], input[type=checkbox]{
      opacity: initial!important;
   }
   input[type='radio']:after {
      width: 20px;
      height: 20px;
      border-radius: 17px;
      top: 0px;
      left: 0px;
      position: relative;
      background-color: #ffffff;
      content: '';
      display: inline-block;
      visibility: visible;
      border: 2px solid black;
    }
   input[type='radio']:checked:after {
      width: 20px;
      height: 20px;
      border-radius: 17px;
      top: 0px;
      left: 0px;
      position: relative;
      background: linear-gradient(45deg, rgba(0, 82, 142, 0.8), rgb(43, 185, 162, 0.8));
      content: '';
      display: inline-block;
      visibility: visible;
      border: 2px solid black;
   }
   .do-calculation{
      grid-column: span 2;
   }
   .calc-input {
      display: block;
      padding: 5px;
      max-width: 250px;
      font-size: 14px;
      font-weight: 600;
      border-radius: 5px;
   }
   .sexInput {
      display: flex;
      justify-content: space-evenly;
      text-align: center;
   }
   .message{
      color: transparent;
      margin-left: 15px;
   }
   .errorMessage{
      color: red;
   }
   #results {
      display: none;
      width: 500px;
   }
   .result-title{
      text-align: center;
      font-size: 1.6rem;
   }
   .targets{
      display: flex;
      justify-content: space-evenly;
   }
   .target-wrapper{
      padding: 10px 20px;
      width: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      color: #ffffff;
   }
   .target-wrapper i{
      color: #ffffff;
   }
   .target-wrapper.calories{
      border-radius: 60px 0 0 0;
      margin-right: 1px;
      background: var(--e-global-color-primary);
   }
   .target-wrapper.protein{
      border-radius: 0 60px 0 0;
      margin-left: 1px;
      background: var(--e-global-color-accent);
   }
   .result-subtitle{
      display: inline;
      padding-left: 10px;
   }
   .result-amount{
      font-weight: bold;
      font-size: 1.5rem;
      text-align: center;
      color: #ffffff;
   }
   .names, .emailSub{
      display: flex;
      justify-content: space-between;
      align-items: center;
   }
   .mergeRow, .submit_container{
      width: 48%;
   }
   ::selection {
    background-color: var(--e-global-color-primary);
   }

   /* range slider styles */
   input[type=range] {
      -webkit-appearance: none;
      width: 100%!important;
   }
   input[type=range]:focus {
      outline: none;
   }
   input[type=range]::-webkit-slider-runnable-track {
      width: 100%;
      height: 8.4px;
      cursor: pointer;
      background: linear-gradient(45deg, rgba(0, 82, 142, 0.8), rgb(43, 185, 162, 0.8));
      border-radius: 10px;
      border: 0.2px solid #010101;
      padding-top: 4px;
   }
   input[type=range]::-webkit-slider-thumb {
      border: 1px solid #000000;
      height: 26px;
      width: 26px;
      border-radius: 50px;
      background: #ffffff;
      cursor: pointer;
      -webkit-appearance: none;
      margin-top: -14px;
   }
   input[type=range]:focus::-webkit-slider-runnable-track {
      background: linear-gradient(45deg, rgba(0, 82, 142, 0.8), rgb(43, 185, 162, 0.8));
   }
   input[type=range]::-moz-range-track {
      width: 100%;
      height: 8.4px;
      cursor: pointer;
      background: linear-gradient(45deg, rgba(0, 82, 142, 0.8), rgb(43, 185, 162, 0.8));
      border-radius: 10px;
      border: 0.2px solid #010101;
      padding-top: 4px;
   }
   input[type=range]::-moz-range-thumb {
      border: 1px solid #000000;
      height: 26px;
      width: 26px;
      border-radius: 50px;
      background: #ffffff;
      cursor: pointer;
   }
   input[type=range]::-ms-track {
      width: 100%!important;
      height: 8.4px;
      cursor: pointer;
      background: transparent;
      border-color: transparent;
      border-width: 16px 0;
      color: transparent;
      padding-top: 4px;
   }
   input[type=range]::-ms-fill-lower {
      background: linear-gradient(45deg, rgba(0, 82, 142, 0.8), rgb(43, 185, 162, 0.8));
      border: 0.2px solid #010101;
      border-radius: 10px;
   }
   input[type=range]::-ms-fill-upper {
      background: linear-gradient(45deg, rgba(0, 82, 142, 0.8), rgb(43, 185, 162, 0.8));
      border: 0.2px solid #010101;
      border-radius: 10px;
   }
   input[type=range]::-ms-thumb {
      border: 1px solid #000000;
      height: 26px;
      width: 26px;
      border-radius: 50px;
      background: #ffffff;
      cursor: pointer;
   }
   input[type=range]:focus::-ms-fill-lower {
      background: linear-gradient(45deg, rgba(0, 82, 142, 0.8), rgb(43, 185, 162, 0.8));
   }
   input[type=range]:focus::-ms-fill-upper {
      background: linear-gradient(45deg, rgba(0, 82, 142, 0.8), rgb(43, 185, 162, 0.8));
   }

   /* remove arrows from number inputs */
   /* Chrome, Safari, Edge, Opera */
   input::-webkit-outer-spin-button,
   input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
   }

   /* Firefox */
   input[type=number] {
      -moz-appearance: textfield;
   }

   .field-shift {
      left: -9999px;
      position: absolute;
   }
   </style>
   
   <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
   
   <script type="module">
      const { createApp } = Vue;
      createApp({
         data() {
            return {
               error: '',

               fname: '',
               lname: '',
   
               weight: 100,
               height: 170,
               age: 35,
               sex: 'female',

               heightValue: {
                  feet: '0',
                  inches: '0'
               },
               weightValue: 100,
               
               lifestyle: 0.7,
               exercise: 0.7,
               
               rmr_harris: 0,
               rmr_mifflin: 0,
               
               tdee_harris: 0,
               tdee_mifflin: 0,
               protein: 0,
   
               health_goal: '',
               health_goal_text: '',
               unit: 'metric',

               weight_unit: 'kg',
               height_unit: 'cm'
            }
         },
         watch:{
            unit(){
               if(this.unit == 'metric'){
                  this.weight_unit = 'kg';
                  this.height_unit = 'cm';
                  document.querySelector('#heightID').setAttribute('max', '230');
                  document.querySelector('#heightID').setAttribute('min', '130');
                  document.querySelector('#weightID').setAttribute('min', '40');
                  document.querySelector('#weightID').setAttribute('max', '180');
                  document.querySelector('.range_indicator.imperial').style.display = 'none';
                  document.querySelector('.range_indicator.metric').style.display = 'initial';
                  this.weight = Math.round(this.weight / 2.20462);
                  this.height = this.height * 2.54;
               }else if(this.unit == 'imperial'){
                  this.weight_unit = 'lb';
                  this.height_unit = 'ft in';
                  document.querySelector('#heightID').setAttribute('max', '90');
                  document.querySelector('#heightID').setAttribute('min', '50');
                  document.querySelector('#weightID').setAttribute('min', '95');
                  document.querySelector('#weightID').setAttribute('max', '400');
                  document.querySelector('.range_indicator.imperial').style.display = 'initial';
                  document.querySelector('.range_indicator.metric').style.display = 'none';
                  this.height = this.height / 2.54;
                  this.weight = Math.round(this.weight * 2.20462);
               }
            },
            height(){
               if(this.unit == 'imperial'){
                  this.heightValue.feet = parseInt(this.height/12);
                  this.heightValue.inches = parseInt(this.height % 12);
               } 
            },
            weight(){
                  this.weightValue = this.weight;
            }
         },
         methods:{
            calculate(){  
               console.log(this.weight, this.height, this.age, this.sex, this.lifestyle, this.exercise);
               if(this.unit == 'imperial'){
                  this.protein = Math.round(this.weight * 0.68);
                  this.weight = this.weight / 2.20462;
                  this.height = this.height * 2.54;
               }
               else{
                  this.protein = this.weight * 1.5;
               }
               if(this.sex == "male"){
                  //this.rmr_harris = 88.362 + (13.397 * this.weight) + (4.799 * this.height) - (5.677 * this.age);
                  this.rmr_mifflin = (10 * this.weight) + (6.25 * this.height) - (5 * this.age) + 5;
               }
               else if(this.sex == "female"){
                  //this.rmr_harris = 447.593 + (9.247 * this.weight) + (3.098 * this.height) - (4.330 * this.age);
                  this.rmr_mifflin = (10 * this.weight) + (6.25 * this.height) - (5 * this.age) - 161;
               }
               //lifestyle + exercise = activity factor
               this.lifestyle = parseFloat(this.lifestyle);
               this.exercise = parseFloat(this.exercise);
               //var tdee_temp = (this.lifestyle + this.exercise) * this.rmr_harris;
               var tdee_temp = (this.lifestyle + this.exercise) * this.rmr_mifflin;
               //this.tdee_mifflin = (this.lifestyle + this.exercise) * this.rmr_mifflin;
               if(this.health_goal == "loseWeight"){
                  //this.tdee_harris = Math.round(tdee_temp * 0.85);
                  this.tdee_mifflin = Math.round(tdee_temp * 0.85);
               }else if(this.health_goal == "buildMuscle"){
                  //this.tdee_harris = Math.round(tdee_temp * 1.15);
                  this.tdee_mifflin = Math.round(tdee_temp * 1.15);
               }else if(this.health_goal == "optimalHealth"){
                  //this.tdee_harris = Math.round(tdee_temp);
                  this.tdee_mifflin = Math.round(tdee_temp);
               }
               this.step3();
            },
            selectOption(option, type, pre){
               if(type == "goal"){
                  this.health_goal = option;
               }else if(type == "unit"){
                  this.unit = option;
               }
               if(document.querySelector('.selected-option')){
                  document.querySelector('.selected-option').classList.toggle('selected-option');
               }
               if(pre){
                  document.querySelector('.'+option).classList.toggle('selected-option');
               }else{
                  event.currentTarget.classList.toggle('selected-option');
               }
            },
            imperialHeightInput(){
               this.height = parseInt(this.heightValue.feet * 12)+ parseInt(this.heightValue.inches);
            },
            step1(){
               this.error = '';
               document.querySelector('#calculator').style.display = 'none';
               document.querySelector('#choices').style.display = 'flex';
               this.selectOption(this.health_goal, 'goal', true);
            },
            step2(){
               if(this.health_goal == '' || this.health_goal == null || !this.health_goal){
                  this.error = "Please select a health goal."
                  document.querySelector('.choice-message').classList.add('errorMessage');
               }
               else{
                  switch(this.health_goal) {
                     case 'loseWeight':
                        this.health_goal_text = "Weight Loss";
                        break;
                     case 'optimalHealth':
                        this.health_goal_text = "Optimal Health";
                        break;
                     case 'buildMuscle':
                        this.health_goal_text = "Building Muscle";
                        break;
                  }
                  this.error = '';
                  document.querySelector('.choice-message').classList.remove('errorMessage');
                  document.querySelector('#calculator').style.display = 'grid';
                  document.querySelector('#choices').style.display = 'none';
                  this.selectOption('metric', 'unit', true);
               }  
            },
            step3(){
               if(!this.fname || this.fname == '' || this.fname == null || !this.lname || this.lname == '' || this.lname == null ){
                  this.error = 'Please enter your name.'
                  document.querySelector('.name-message').classList.add('errorMessage');
               }else{
                  this.error = '';
                  document.querySelector('.name-message').classList.remove('errorMessage');
                  document.querySelector('#calculator').style.display = 'none';
                  document.querySelector('#results').style.display = 'block';
               }
                  
            }
         }
      }).mount('#app')
   </script>
      
   <div id="app">
      <div class="choices" id="choices">
         <h4>My goal is to...</h4>
         <div class="options loseWeight" @click="this.selectOption('loseWeight', 'goal', false)">
            <i class="fas fa-weight"></i>
            <div>
               <h5>Lose Weight</h5>
               <p>Lose fat and improve health.</p>
            </div>
         </div>
         <div class="options optimalHealth" @click="this.selectOption('optimalHealth', 'goal', false)">
            <i class="fas fa-apple-alt"></i>
            <div>
               <h5>Optimal Health</h5>
               <p>Perform at your best or maintain your weight.</p>
            </div>
         </div>
         <div class="options buildMuscle" @click="this.selectOption('buildMuscle', 'goal', false)">
            <i class="fas fa-dumbbell"></i>
            <div>
               <h5>Build Muscle</h5>
               <p>Gain muscle, weight and/or strength.</p>
            </div>
         </div>
         <p class="choice-message message">{{ this.error }}</p>
         <button class="next-step" @click="this.step2">Next</button>
      </div>
      <div class="calculator" id="calculator">
         <h4 class="calculator-title">Macro Calculator for {{ this.health_goal_text }}</h4>
         <label>First Name
            <input id="fnameID" class="calc-input" type="text" v-model="fname">
         </label>
         <label>Last Name
            <input id="lnameID" class="calc-input" type="text" v-model="lname">
         </label>
         <span class="metric unit" @click="this.selectOption('metric', 'unit', false)">Metric</span>
         <span class="imperial unit" @click="this.selectOption('imperial', 'unit', false)">Imperial</span>
         <label class="weightInput">Weight ({{ this.weight_unit }})*
            <input type="number" class="range_indicator weight" v-model="weight">
            <input id="weightID" required class="calc-input weightInput" min="40" max="180" valueAsNumber type="range" v-model="weight">
         </label>
         <label class="heightInput">Height ({{ this.height_unit }})*
            <input type="number" class="range_indicator metric" v-model="height">
            <div class="range_indicator imperial">
               <input type="number" class="range_indicator" v-model="heightValue.feet" @change="this.imperialHeightInput()"> ft
               <input type="number" class="range_indicator" v-model="heightValue.inches" @change="this.imperialHeightInput()"> in
            </div>
            <input id="heightID" required class="calc-input heightInput" min="130" max="230" type="range" valueAsNumber v-model="height">
         </label>
         <label class="ageInput">Age*
            <input id="ageID" required class="calc-input ageInput" min="18" max="80" type="number" v-model="age">
         </label>
         <div class="calc-input">
            <div class="calc-input">Sex (at birth)* </div>
            <div class="sexInput">
               <span>
                  <input type="radio" v-model="sex" id="femaleID" value="female">
                  <label for="femaleID">Female</label>
               </span>
               <span>
                  <input type="radio" v-model="sex" id="maleID" value="male">
                  <label for="maleID">Male</label>
               </span>
            </div>
         </div>
         <label class="lifestyleInput">Lifestyle*
            <select id="lifestyleID" name="lifestyle" required class="calc-input lifestyleInput" v-model="lifestyle">
            <option disabled value="">Please select one</option>
            <option value=0.7>Sedentary (desk job, very little standing or walking needed during the day)</option>
            <option value=0.8>Light Activity (some standing and walking during day to day activities and job)</option>
            <option value=0.9>Moderate Activity (you spend a good portion of the day on your feet during your job and activities)</option>
            <option value=1.0>High Activity (you spend virtually all day on your feet and rarely sit down)</option>
            <option value=1.1>Extreme Activity (you work a heavy labour job)</option>
            </select>
         </label>
         <label class="exerciseInput">Exercise Factor*
            <select id="exerciseID" name="exercise" required class="calc-input exerciseInput" v-model="exercise">
            <option disabled value="">Please select one</option>
            <option value=0.7>Sedentary (you don't exercise)</option>
            <option value=0.8>Light Exercise (you do some walking and aerobic activity a few days per week)</option>
            <option value=0.9>Moderate Exercise (you do multiple days per week of exercise, some resistance training)</option>
            <option value=1.15>Intense Exercise (you train HARD at least 5 days per week)</option>
            <option value=1.2>Extreme Exercise (you train intensely over 2 hours per day, virtually every day)</option>
            </select>
         </label>
         <p class="name-message message">{{ this.error }}</p>
         <button id="calc" class="do-calculation next-step" @click="this.calculate">Calculate!</button>   
         <a class="go-back" @click="this.step1()">Back</a>
      </div>
      <div id="results">
         <h4 class="result-title">Your Daily Protein & Calorie Targets for {{ this.health_goal_text }}</h4>
         <div class="targets">
            <span class="target-wrapper calories">
               <span>
                  <i class="fas fa-fire"></i><p class="result-subtitle">Calories</p>
                  <!--<p class="result-amount">{{ tdee_harris }}</p>-->
                  <p class="result-amount">{{ tdee_mifflin }}</p>
               </span>
            </span>
            <span class="target-wrapper protein">
               <span>
                  <i class="fas fa-drumstick-bite"></i><p class="result-subtitle">Protein</p>
                  <p class="result-amount">{{ protein }}g</p>
               </span>
            </span>
         </div>
         <div class="explanation">
            <h6>Does this look different than usual?</h6>
            <p>I know! What gives? My Fitness Pal punches out very different numbers! And why is there nothing about carbs and fats?!</p>
            <p>Enter your email below and I promise to send you my explanation to clear everything up!</p> 
            <p>I'll also send you my Weekly Health Journal template to get you started on achieving your health goals!</p>
            
            <form action="https://healthevolved.us17.list-manage.com/subscribe/post" method="POST" autocomplete="off">
               <input type="hidden" name="u" value="4e768503ae846051e79024e56">
               <input type="hidden" name="id" value="c28552bbba">
               <div id="mergeTable" class="mergeTable">
                  <input type="checkbox" id="group_4" name="group[280765][4]" value="1" class="av-checkbox" style="display:none;" checked aria-checked="true">
                  <input type="hidden" name="mc_signupsource" value="hosted">
                  <div class="names">
                     <div class="mergeRow dojoDndItem mergeRow-text" id="mergeRow-1">
                        <label for="MERGE1">First Name <span class="req asterisk">*</span></label>
                        <div class="field-group">
                           <input type="text" name="MERGE1" id="MERGE1" size="25" value="" v-model="fname">
                        </div>
                     </div>
                     <div class="mergeRow dojoDndItem mergeRow-text" id="mergeRow-2">
                        <label for="MERGE2">Last Name</label>
                        <div class="field-group">
                           <input type="text" name="MERGE2" id="MERGE2" size="25" value="" v-model="lname">
                        </div>
                     </div>
                  </div>
                  <div class="emailSub">
                     <div class="mergeRow dojoDndItem mergeRow-email" id="mergeRow-0">
                        <label for="MERGE0">Email Address <span class="req asterisk">*</span></label>
                        <div class="field-group">
                            <input type="email" autocapitalize="off" autocorrect="off" name="MERGE0" id="MERGE0" size="25" value="" autocomplete="off">
                        </div>
                     </div>
                     <div class="submit_container clear">
                        <button type="submit" class="formEmailButton" name="submit" value="Subscribe">Subscribe</button>
                    </div>
                  </div>
               </div>
           </form>
         
         </div>
      </div>
   </div>
   
   
    <?php
   	return ob_get_clean();
}
