<template>
    <div class='row'> 
		<div class='row'> 
			
		</div>
		<div class="col-md-6 mb-6">    
			<div clss="row">
				<div class="col-md-12 mb-12 card indigo form-white">
					<h2 class="text-center default-text py-3">Quizzes</h2>
					<ul class="list-group">
						<div v-for="(question, index) in quiz" :key="question.question" >
							<div v-show="index === questionIndex">
								<li class="list-group-item"><h2>{{ question.question }}</h2></li>
								<li class="list-group-item" v-for="response in question.responses" :key="response">
									<input type="radio" 
									   v-bind:value="response.correct" 
									   v-bind:name="index" 
									   v-model="userResponses[index]"> {{response.correct_answer}}
								</li>
								<li class="list-group-item" style="padding:30px;">
									<button  v-if="questionIndex > 0" v-on:click="prev" class="btn btn-danger btn-xs pull-right" style="margin-top: -10px;">Previos</button>
									<button v-on:click="next" class="btn btn-danger btn-xs pull-right" style="margin-top: -10px;">Next</button>
								</li>
							</div>
						</div>
						
						
						<div v-show="questionIndex === quiz.length">
							<li class="list-group-item">
								<h2>
									Quiz finished
								</h2>
								<p>
									Total score: {{ score() }} / {{ quiz.length }}
								</p>
							</li>
						</div>
					</ul>
				</div>
			</div>
		</div>
	</div>
</template>


<script>
    export default {
		
        data() {
            return {
                list: '',
				quiz: [],
				questionIndex: 0,
				userResponses: [],
            };
        },
        
        created() {
            this.fetchQuizList();
        },
        
        methods: {
            fetchQuizList() {
                axios.get('/questions').then((res) => {
					this.quiz = res.data;
					this.userResponses = Array(this.quiz.length).fill(false)
                });
            },
			
			next: function() {
			  this.questionIndex++;
			},
			
			prev: function() {
			  this.questionIndex--;
			},
			
			score: function() {
			  return this.userResponses.filter(function(val) { return val }).length;
			}
	  }
    }
</script>