<template>
	<div class="container px-5">
		<div class="row justify-content-center">
			<div class="col-lg-8 align-items-center">
				<div class="card border-0 rounded-3 shadow-lg">
					<div class="card-body p-4">
						<div class="text-center">
							<div class="h1 fw-light">Currency Converter</div>
							<p class="mb-4 text-muted">
								A simple currency converter supporting 3
								currencies
							</p>
						</div>

						<form @submit.prevent="calculate">
							<!-- Currency selects -->
							<div class="row">
								<div class="col">
									<div class="form-floating mb-3">
										<select
											class="form-control"
											type="text"
											placeholder="Currency 1"
											v-model="userInput.currencyIds[0]"
										>
											<option
												v-for="currency in currencies"
												:key="currency.id"
												:value="currency.id"
											>
												{{ currency.name }}
											</option>
										</select>
										<label for="name">Currency</label>
									</div>
								</div>
								<div
									class="
										col-2
										d-flex
										justify-content-center
										align-items-center
									"
								>
									<div class="mb-3">
										<svg
											xmlns="http://www.w3.org/2000/svg"
											width="32"
											height="32"
											fill="currentColor"
											class="bi bi-arrow-left-right"
											viewBox="0 0 16 16"
											@click="swap"
										>
											<path
												fill-rule="evenodd"
												d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5zm14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5z"
											/>
										</svg>
									</div>
								</div>
								<div class="col">
									<div class="form-floating mb-3">
										<select
											class="form-control"
											type="text"
											placeholder="Currency 2"
											v-model="userInput.currencyIds[1]"
										>
											<option
												v-for="currency in currencies"
												:key="currency.id"
												:value="currency.id"
											>
												{{ currency.name }}
											</option>
										</select>
										<label for="name">Currency</label>
									</div>
								</div>
							</div>

							<!-- Amount Input -->
							<div class="form-floating mb-3">
								<input
									class="form-control"
									type="number"
									placeholder="Amount"
									v-model.number="userInput.amount"
									@keypress="validate($event)"
								/>
								<label for="amount">Amount</label>
							</div>

							<!-- Result -->
							<div class="form-floating mb-3">
								<div class="card">
									<div class="card-body text-center">
										<p v-if="result" class="my-auto py-0">
											{{ result }}
										</p>
										<p
											v-else
											class="my-auto py-0 text-muted"
										>
											Result
										</p>
									</div>
								</div>
							</div>

							<!-- Submit button -->
							<div class="d-grid">
								<button
									class="btn btn-primary btn-lg"
									type="submit"
								>
									Submit
								</button>
							</div>
						</form>
						<!-- End of contact form -->
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import api from "../../js/api";

	export default {
		mounted() {
			this.fetchCurrencies();
			this.fetchCurrencyRatios();
		},
		data() {
			return {
				userInput: {
					currencyIds: [1, 1],
					currencies: [],
					amount: "",
				},
				currencies: [],
				ratios: [],
				result: "",
			};
		},
		methods: {
			fetchCurrencies() {
				api.get("/getCurrencies")
					.then((res) => {
						this.currencies = res.data;
					})
					.catch((err) => console.log(err));
			},
			fetchCurrencyRatios() {
				api.get("/currencyRatios")
					.then((res) => {
						this.ratios = res.data;
					})
					.catch((err) => console.log(err));
			},
			calculate() {
				_.map(this.ratios).forEach((ratio) => {
					if (_.isEqual(ratio.pair, this.userInput.currencyIds)) {
						this.result = (this.userInput.amount * ratio.ratio).toFixed(
							2
						);
					}
				});
			},
			validate(evt) {
				const keysAllowed = [
					"0",
					"1",
					"2",
					"3",
					"4",
					"5",
					"6",
					"7",
					"8",
					"9",
					".",
				];
				const keyPressed = evt.key;

				if (!keysAllowed.includes(keyPressed)) {
					evt.preventDefault();
				}
			},
			swap() {
				this.userInput.currencyIds = _.reverse(this.userInput.currencyIds);
			},
		},
	};
</script>