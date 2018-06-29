<template>
    <div class="row main">
        <div class="col-sm-6">
            <h5>Customer Name:  {{ customer.name }}</h5>
            <h5>Account Bal.: {{ customer.account_balance }}</h5>
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-8 text-right">
                    <h5>Sub-Total</h5>
                    <h5>Discount</h5>
                    <h4><strong>Total</strong></h4>
                    <h4><strong>Change</strong></h4>
                </div>
                <div class="col-sm-4 text-right">
                    <h5>{{ parseFloat(total_inclusive).toFixed(2) }}</h5>
                    <h5>{{ isNaN(discount) ? 0 : discount }}</h5>
                    <h4><strong>{{ parseFloat(parseFloat(total_inclusive)).toFixed(2) }}</strong></h4>
                    <h4><strong>{{ parseFloat(balance).toFixed(2) }}</strong></h4>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <table class="table">
                <thead>
                <tr>
                    <th class="text-nowrap">Code</th>
                    <th class="text-nowrap">Rate</th>
                    <th class="text-nowrap text-right" width="150px">Net AMT</th>
                    <th class="text-nowrap text-right">VAT Amount</th>
                    <th class="text-nowrap text-right">Total Amount</th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="taxes.length" v-for="tax in taxes">
                    <td>{{tax.code}}</td>
                    <td>{{tax.rate}}%</td>
                    <td class="text-right">
                        {{ parseFloat(tax.rate) > 0 ? Math.round(((parseFloat(100) - parseFloat(tax.rate)) / parseFloat(100)) * parseFloat(total_inclusive)).toLocaleString('en-GB') : 0}}
                    </td>
                    <td class="text-right">
                        {{ parseFloat(tax.rate) > 0 ? Math.round((parseFloat(total_inclusive) - (((parseFloat(100) - parseFloat(tax.rate)) / parseFloat(100)) * parseFloat(total_inclusive)))) : 0
                        }}
                    </td>
                    <td class="text-right">{{parseFloat(tax.rate) > 0 ? total_inclusive.toLocaleString('en-GB') : 0}}
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="form-group">
                <label for="comment">Comment</label>
                <textarea id="comment" v-model="notes" class="form-control input-sm" rows="2"></textarea>
            </div>
        </div>
        <div class="col-md-6 payment-form">
            <table class="table">
                <tbody>
                <tr>
                    <td>Cash</td>
                    <td class=""><input v-model="cash_amount" type="number" min="0"
                                        class="form-control input-sm text-right" onfocus="this.select()" autofocus/>
                    </td>
                </tr>
                <tr>
                    <td>Credit</td>
                    <td class=""><input v-model="credit_amount" type="number" min="0"
                                        class="form-control input-sm text-right"
                                        :disabled="!parseInt(customer.is_credit) == 1"/></td>
                </tr>
                <tr>
                    <td>M-PESA</td>
                    <td>
                        <div style="display:flex;" v-for="row in rows">
                            <div class="form-group">
                                <label v-if="parseInt(row.default) == 1">Code</label>
                                <input v-model="row.m_pesa_code" type="text" onfocus="this.select()"
                                       class="form-control input-sm text-right"
                                       style="width:110px; margin-right: 20px;"/>
                            </div>
                            <div class="form-group">
                                <label v-if="parseInt(row.default) == 1">Amount :</label>
                                <input v-model="row.m_pesa_amount" type="number" onfocus="this.select()" min="0"
                                       class="form-control input-sm text-right"
                                       style="width:110px; margin-right: 20px;"/>
                            </div>

                            <div class="form-group">
                                <button v-if="parseInt(row.default) == 1" @click.prevent="addMpesaField"
                                        class="btn btn-success btn-xs" style="margin-top:25px;"><i
                                        class="fa fa-plus"></i></button>
                                <button v-if="parseInt(row.default) == 0"
                                        @click.prevent="removeMpesaField(rows.indexOf(row))"
                                        class="btn btn-danger btn-xs" style="margin-top:5px;"><i
                                        class="fa fa-minus"></i></button>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Credit Card</td>
                    <td>
                        <div style="display:flex;" v-for="creditRow in creditRows">
                            <div class="form-group">
                                <label v-if="parseInt(creditRow.credit_default) == 1">Code</label>
                                <input v-model="creditRow.credit_card_code" type="text" onfocus="this.select()"
                                       class="form-control input-sm text-right"
                                       style="width:110px; margin-right: 20px;"/>
                            </div>
                            <div class="form-group">
                                <label v-if="parseInt(creditRow.credit_default) == 1">Amount :</label>
                                <input v-model="creditRow.credit_card_amount" type="number" onfocus="this.select()" min="0"
                                       class="form-control input-sm text-right"
                                       style="width:110px; margin-right: 20px;"/>
                            </div>

                            <div class="form-group">
                                <button v-if="parseInt(creditRow.credit_default) == 1" @click.prevent="addCreditField"
                                        class="btn btn-success btn-xs" style="margin-top:25px;"><i
                                        class="fa fa-plus"></i></button>
                                <button v-if="parseInt(creditRow.credit_default) == 0"
                                        @click.prevent="removeCreditField(creditRows.indexOf(creditRow))"
                                        class="btn btn-danger btn-xs" style="margin-top:5px;"><i
                                        class="fa fa-minus"></i></button>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="pull-right" style="margin-right: 10px;">
            <button type="button" class="btn btn-sm btn-danger" @click.prevent="back">Back</button>
            <button type="button" class="btn btn-sm btn-info" @click.prevent="completeSale()">Complete Sale</button>
        </div>
    </div>
</template>
<style scoped>
    .main {
        margin-top: -50px
    }

    .payment-form {
        margin-top: 35px
    }
</style>
<script>
    export default {

        data() {
            return {
                cash_amount: 0,
                credit_amount: this.customer.is_credit == 1 ? 0 : "",
                notes: "",
                transaction_codes: "",
                rows:
                    [
                        {
                            m_pesa_code: "",
                            m_pesa_amount: 0,
                            default: 1
                        }
                    ],
                creditRows:
                [
                    {
                        credit_card_code: "",
                        credit_card_amount: 0,
                        credit_default: 1
                    }
                ]
            }
        },
        watch: {},
        computed: {
                balance() {
                let discount = parseFloat(this.discount);
                discount = isNaN(discount) ? 0 : discount;
                let total = parseFloat(this.total_inclusive) - discount;

                let mpesa = this.rows.map(row => {
                    return row.m_pesa_amount;
                }).reduce((prev, nex) => {
                    nex = parseFloat(nex);
                    nex = isNaN(nex) ? 0 : nex;

                    return prev + nex;
                }, 0);

                let creditCard = this.creditRows.map(creditRow => creditRow.credit_card_amount)
                    .reduce((prev, nex) => {
                        nex = parseFloat(nex);
                        nex = isNaN(nex) ? 0 : nex;

                        return prev + nex;
                    }, 0);

                let credit = parseFloat(this.credit_amount);
                let cash = parseFloat(this.cash_amount);
                credit = isNaN(credit) ? 0 : credit;
                cash = isNaN(cash) ? 0 : cash;

                let paid = credit + cash + mpesa + creditCard;
                let balance = paid - total;

                return balance < 0 ? 0 : balance;
            },
            validateCompletion() {
                 let m_pesa_total = this.rows.map(row => {
                    return row.m_pesa_amount;
                }).reduce((a, b) => {
                    return parseFloat(a) + parseFloat(b);
                });
                let credit_card_total = this.creditRows.map(creditRow => {
                    return creditRow.credit_card_amount;
                }).reduce((prev, nex) => {
                    return parseFloat(prev) + parseFloat(nex);
                });
                if (!parseFloat(m_pesa_total)) m_pesa_total = 0;
                if (!parseFloat(credit_card_total)) credit_card_total = 0;
                if (!parseFloat(this.credit_amount)) this.credit_amount = 0;
                let balance = (parseFloat(m_pesa_total) + parseFloat(this.cash_amount) + parseFloat(this.credit_amount)) + parseFloat(this.credit_card_total) - parseFloat(this.total_inclusive);
                // if(parseFloat(balance) < 0) return "Amount Is Not Enough!";
                return balance < 0 ? false : true;
            },
        },

        methods: {
            paymentType(e) {
                console.log("testing ...");
                return;
                if (!e.target.id) {
                    console.log(this.payment_types[1]);
                    localStorage.setItem('payment_method', this.payment_types[1].id);
                    return this.payment_types[1];
                }
                let payment_method = this.payment_types.filter(payment_method => {
                    return parseInt(payment_method.id) == parseInt(e.target.id);
                })[0];

                this.payment_method = payment_method;
            },
            completeSale() {
                if (!this.validateCompletion) {
                    Messenger().post({
                        message: "Please Complete Payment!",
                        type: 'error',
                        showCloseButton: true
                    });
                    return;
                }
                this.$emit('paymentType', this.cash_amount, this.rows, this.credit_amount, this.balance, this.notes, this.creditRows);
            },

             back() {
                this.$emit('toggleCheckout');
            },

            addMpesaField() {
                return this.rows.push({m_pesa_code: "", m_pesa_amount: 0, default: 0});
            },

            removeMpesaField(row) {
                return this.rows.splice(row, 1);
            },

            addCreditField() {
                return this.creditRows.push({
                    credit_card_code: "", credit_card_amount: 0, credit_default: 0
                });
            },

            removeCreditField(creditRow) {
                return this.creditRows.splice(creditRow, 1)
            }
        },
        props: {
            total_inclusive: {
                type: Number,
                default: 0,
            },
            payment_types: {
                type: Array,
                default() {
                    return [];
                },
            },
            customer: {
                type: Object,
                default() {
                    return {};
                },
            },
            taxes: {
                type: Array,
                default() {
                    return [];
                },
            },
            saleLines: {
                type: Array,
                default() {
                    return []
                },
            },
            discount: {
                type: Number,
                default: 0,
            },
        },
    }
</script>
