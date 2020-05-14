<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Questions</div>
                
                <div class="card-body">
                

              
            <div v-for="(question, index) in questions" :key="question.question">
                <div v-show="index === questionIndex">
                    Question {{index + 1}}.<br/><span v-html="question.question"></span>
                    <p>Catagory: {{question.category}}</p>
                    <p> Question Difficulty: {{question.difficulty}}</p><br/>
                    
                       
                </div>

            </div>
           
            <!-- {{questions[questionIndex].correct_answer}} -->
            
                
                 <div v-for="(option, index) in answersShuffled" :key="option.option">
                    <div v-show="index === questionIndex">
                            <li>A. <span v-html="option[0]"></span></li>
                            <li>B. <span v-html="option[1]"></span></li>
                        <div v-if="option.length < 3">
                        </div>
                        <div v-else>
                            <li>C. <span v-html="option[2]"></span></li>
                            <li>D. <span v-html="option[3]"></span></li>
                        </div>
                        
                        <br/>
                        <select v-model="userResponses[index]" v-bind:name="index" >
                            <option disabled value="">Please select one</option>
                            <option><span v-html="option[0]"></span></option>
                            <option><span v-html="option[1]"></span></option>
                        
                            <option><span v-html="option[2]"></span></option>
                            <option><span v-html="option[3]"></span></option>
                        
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

                <div v-show="questionIndex === questions.length">
					<li class="list-group-item">
						<h2>
							Quiz finished
                            <span>Your Total score is {{score}} / {{questions.length}}</span>
						</h2>
                        <form action="/api/score" method="POST"  @submit.prevent="addScore()">
                                <div class="form-group">
                                        <input type="text" v-model="userName" name="username" placeholder="Enter what you would like to be called" class="form-control">
                                </div>
                                <div class="col-md-4 text-center">
                                        <button class="btn btn-primary" type="submit">Submit Score</button>
                                </div>

                        
                        </form>
						<p>
							<!-- Total score: {{ score() }} / {{ quiz.length }} -->
						</p>
					</li>
				</div>
                {{ timeLeft }}
                <ul class="columns is-mobile is-centered">
                    <li v-for="(time, index) in times" :key="index" class="column time">
                    <a v-on:click.prevent="setTime(time.sec)" :class="[
                    'button',
                    'is-link',
                    {'is-active': time.sec === selectedTime && endTime !== 0 }
                    ]">
                    {{ times.display }}
                    </a>
                     </li>
                 </ul>

                </div>
            </div>
        </div>
    </div>
</div>
</template>



<script> 
        const baseURL = "/questions"
        var intervalTimer;
       

 import shuffle from 'lodash/shuffle';       
    export default {
        data() {

            return {
                
                questions: null,
                answers:  [[], [], [], [], [], [], [], [], [], []],
                answersShuffled: [],
                userResponses: [],
                questionIndex: 0,
                userScore: '',
                userName: '',
                finalScore: 0,

                i: null,
                j: null,

                selectedTime: 0,
                timeLeft: '00:00',
                endTime: '0',
                times: [
               
                {
                sec: 600,
                display: ' 10m'
                },
          
                ]
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
                        for (this.i =0; this.i < this.questions.length; this.i++){
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
                },
                addScore() {
                    
                    this.userScore = this.score + '/' + this.questions.length
                    this.finalScore = this.finalScore + this.score
                    console.log(this.userScore)

                    axios.post('/api/score', {scoreInt: this.finalScore, userScore: this.userScore, userName: this.userName})
                        .then(response => {
                            console.log(response)
                        }).catch(function (error) {
                            console.log(error);
                        });
                    //  const params = new URLSearchParams();
                    //     params.append('event_id', 20);
                    //     params.append('item_id', 30);
                    //     params.append('description', 'my item');
                    // axios({
                    //     method: 'post',
                    //     url: '/api/score',
                    //     data: params
                    //     });

                    // axios.post('/api/score', {postId: 1, userId: 1}, { 
                    //         headers: {
                    //         'content-type': 'application/json'
                    //         }
                    // }
                    // ) 
                    // .then(response => {
                    //         console.log(response)
                    //     }).catch(function (error) {
                    // console.log(error);
                    // });


                },
                 setTime(seconds) {
                 clearInterval(intervalTimer);
                 this.timer(seconds);
                    },
                timer(seconds) {
                  const now = Date.now();
                  const end = now + seconds * 1000;
                 this.displayTimeLeft(seconds);

                 this.selectedTime = seconds;
                // this.initialTime = seconds;
                 this.displayEndTime(end);
                 this.countdown(end);
                },
                countdown(end) {
                 // this.initialTime = this.selectedTime;
                intervalTimer = setInterval(() => {
                 const secondsLeft = Math.round((end - Date.now()) / 1000);

                 if(secondsLeft === 0) {
                  this.endTime = 0;
                }

                if(secondsLeft < 0) {
                 clearInterval(intervalTimer);
                 return;
                }
                 this.displayTimeLeft(secondsLeft)
                 }, 1000);
                },
                displayTimeLeft(secondsLeft) {
                const minutes = Math.floor((secondsLeft % 3600) / 60);
                const seconds = secondsLeft % 60;

                 this.timeLeft = `${zeroPadded(minutes)}:${zeroPadded(seconds)}`;
                 },
                 displayEndTime(timestamp) {
                const end = new Date(timestamp);
                const hour = end.getHours();
                const minutes = end.getMinutes();

                this.endTime = `${hourConvert(hour)}:${zeroPadded(minutes)}`
                 },
      

                
            
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
                function zeroPadded(num) {
                // 4 --> 04
                 return num < 10 ? `0${num}` : num;
                 }

                function hourConvert(hour) {
                // 15 --> 3
                 return (hour % 12) || 12;
}


    
</script>


