<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Questions</div>
                
                <div class="card-body">
                

              
            <div v-for="(question, index) in questions" :key="question.question">
                <div v-show="index === questionIndex">
                    Question {{index + 1}}.<br/> {{question.question}}
                    <p>Catagory: {{question.category}}</p>
                    <p> Question Difficulty: {{question.difficulty}}</p><br/>
                    
                       
                </div>

            </div>
           
            <!-- {{questions[questionIndex].correct_answer}} -->
            
                
                 <div v-for="(option, index) in answersShuffled" :key="option.option">
                    <div v-show="index === questionIndex">
                            <li>A. {{option[0]}}</li>
                            <li>B. {{option[1]}}</li>
                        <div v-if="option.length < 3">
                        </div>
                        <div v-else>
                            <li>C. {{option[2]}}</li>
                            <li>D. {{option[3]}}</li>
                        </div>
                        
                        <br/>
                        <select v-model="userResponses[index]" v-bind:name="index" >
                            <option disabled value="">Please select one</option>
                            <option>{{option[0]}}</option>
                            <option>{{option[1]}}</option>
                        
                            <option>{{option[2]}}</option>
                            <option>{{option[3]}}</option>
                        
                        </select>
                        <br/>
                        <span>Selected: {{ userResponses[index] }}</span> <br/>
                        
                        <br/>
                         <span>Your Total score is {{score}} / {{questions.length}}</span>
                    </div>
                </div>
                <br/>
              
                <li class="list-group-item" style="padding:30px;">
					<button  v-if="questionIndex > 0" v-on:click="prev" class="btn btn-danger btn-xs pull-right" style="margin-top: -10px;">Previos</button>
					<button v-on:click="next"  class="btn btn-danger btn-xs pull-right" style="margin-top: -10px;">Next</button>
				</li>

                <div v-show="questionIndex === answers.length">
					<li class="list-group-item">
						<h2>
							Quiz finished
                            <span>Your Total score is {{score}} / {{questions.length}}</span>
						</h2>
						<p>
							<!-- Total score: {{ score() }} / {{ quiz.length }} -->
						</p>
					</li>
				</div>

                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script> 
        const baseURL = "/questions"
 import shuffle from 'lodash/shuffle';       
    export default {
        data() {

            return {
                
                questions: null,
                answers:  [[], [], [], [], [], [], [], [], [], []],
                answersShuffled: [],
                userResponses: [],
                questionIndex: 0,

                i: null,
                j: null,
            }
        },
        methods: {
            getQuestions(){
                axios.get(baseURL)
                     .then((response) => {
                        
                            this.questions = response.data
                            this.userResponses = Array(this.questions.length).fill('')
                            console.log(this.userResponses)

                            console.log(response.data.length)
                            console.log(response.data)

                        for (this.i = 0; this.i < response.data.length; this.i++) {
                            let correctAnswers = response.data[this.i].correct_answer
                                this.answers[this.i].push(correctAnswers)
                            for (this.j=0; this.j<response.data[this.i].incorrect_answers.length; this.j++){
                                let incorrectAnswers = response.data[this.i].incorrect_answers[this.j]
                                this.answers[this.i].push(incorrectAnswers)
                            }
                   
                                    
                                }
                        for (this.i =0; this.i < this.answers.length; this.i++){
                            // let hello = shuffle(this.answers[this.i])

                            this.answersShuffled.push(shuffle(this.answers[this.i]))
                        }
                            console.log(this.answersShuffled)
                        })
                },
                next: function() {
			    this.questionIndex++;
                },
                prev: function() {
			    this.questionIndex--;
                }
                
            
        },
        
        
        created() {
            this.getQuestions()
            
           
        
            
        },
         computed:{
 
                score: function() {
                var total = 0;
                for (var i =0; i < this.questions.length; i++) {
                if(this.userResponses[i] == this.questions[i].correct_answer){
                    // console.log(this.userResponses[i])
                    // console.log(this.questions[i].correct_answer)
                    total +=1;
                    }
                    }
                return total;
            }
         }
    
    }
    


    
</script>