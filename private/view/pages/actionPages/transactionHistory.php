<div class="container mt-5">

    <div class="row p-3">
        <div class="col my-4 p-3 bg-white border shadow-sm lh-sm">
            <div class="table-list-title">
                <h2 class="ps-4">List All Transaction</h2>
                <div class="dropdown ">
                    <button class="btn btn-secondary dropdown-toggle list__type-account" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Type of Transaction
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#" onclick="renderTrans('withdraw')">With draw</a>
                        <a class="dropdown-item" href="#" onclick="renderTrans('transfer')">Transfer</a>
                        <a class="dropdown-item" href="#" onclick="renderTrans('recharge')">Recharge</a>
                        <a class="dropdown-item" href="#" onclick="renderTrans('phonecard')">Phone Card</a>
                        <a class="dropdown-item" href="#" onclick="renderTrans('')">All Transaction</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive table-data_admin">
            <table id="table__details" class="table table-bordered table-striped mt-0">
                <thead id="thead__details">

                </thead>
                <tbody id="tbody__details">
                </tbody>
            </table>
        </div>
        <!-- Modal transaction-->
        <div class="modal fade" id="modal__details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Transaction details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead id="transaction-thead" class="thead-dark ">
                                </thead>
                                <tbody id="transaction-tbody">
                                </tbody>
                            </table>
                            <table class="table phoneCardtb">
                                <thead id="phoneCard-thead" class="thead-dark ">
                                </thead>
                                <tbody id="phoneCard-tbody">
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <nav aria-label="dataTables_paginate paging_simple_numbers">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>

    </div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


<script>
    const urlAllTransaction = 'http://localhost/api/transaction/transaction-histories/'
    const urlDetailTransaction = 'http://localhost/api/transaction/transaction-detail/'
    const urlphoneCardTransaction = 'http://localhost/api/transaction/phone-card-transaction/'


    // show list item
    function renderData(url = urlAllTransaction) {
        fetch(url)
            .then(response => response.json())
            .then(response => {

                if (response.status == true) {
                    thead = `<tr>
                                <th>Transaction id</th>
                                <th>Email</th>
                                <th>Type_transaction</th>
                                <th>Value money</th>
                                <th>Create At</th>
                                <th>Action</th>
                                <th>View</th>
                            </tr>`
                    $('#thead__details').html(thead)
                    $('#tbody__details').html(response.data.map((element) => {
                        if (element.type_transaction == '2') {
                            actionclass = 'warning'
                            transactionName = 'transfer transaction'
                        } else if (element.type_transaction == '3') {
                            actionclass = 'success'
                            transactionName = 'withdraw transaction'
                        } else if (element.type_transaction == '4') {
                            actionclass = 'primary'
                            transactionName = 'phoneCard transaction'
                        } else if (element.type_transaction == '1') {
                            actionclass = 'danger'
                            transactionName = 'recharge transaction'
                        } else {
                            actionclass = 'light'
                            transactionName = 'recharge transaction'
                        }

                        if (element.action == 1) {
                            colorActionClass = 'success'
                            actionValue = 'success'
                        } else if (element.action == 2) {
                            colorActionClass = 'danger'
                            actionValue = 'failed'
                        } else {
                            colorActionClass = 'primary'
                            actionValue = 'pending'
                        }
                        return `
                                <tr>
                                    <td>${element.transaction_id}</td>
                                    <td class="align-middle">
                                        ${element.email}
                                    </td>
                                    <td class="align-middle"><span class="badge badge-` + actionclass + `">${transactionName}</span></td>
                                    <td>${element.value_money}</td>
                                    <td>${createdTime(element.createdAt)}</td>
                                    <td class="align-middle"><span class="badge badge-` + colorActionClass + `">${actionValue}</td>
                                    <td class="align-middle text-center">
                                        <button class="btn btn-theme btn_show" data-toggle="modal" data-target="#modal__details"
                                            onclick="transaction_detail(` + element.transaction_id + `)">
                                        <i class="fa fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            `
                    }))
                } else {
                    $('#tbody__details').html(response.msg)
                }
            })

    }

    renderData();

    function renderTrans(params) {

        renderData(urlAllTransaction + params);
    }

    function transaction_detail(transaction_id) {
        fetch(urlDetailTransaction + transaction_id)
            .then(response => response.json())
            .then(response => {
                if (response.status) {
                    trans = response.data
                    for (const property in trans) {
                        if (trans[property] == null) {
                            delete trans[property];
                        }
                    }
                    console.log(trans);
                    if (trans.type_transaction == '4') {
                        fetch(urlphoneCardTransaction + trans.transaction_id)
                            .then(response => response.json())
                            .then(response => {
                                if (response.status) {
                                    listCard = response.data
                                    $('#transaction-thead').html(`
                                        <tr>
                                            <th scope="col">transaction id</th>
                                            <th scope="col">email</th>
                                            <th scope="col">type transaction</th>
                                            <th scope="col">money</th>
                                            <th scope="col">amount</th>
                                            <th scope="col">created At</th>
                                        </tr>
                                    `)
                                    $('#transaction-tbody').html(`
                                        <tr>
                                            <th scope="row">${trans.transaction_id}</th>
                                            <td>${trans.email}</td>
                                            <td>buy phone card transaction</td>
                                            <td>${trans.value_money}</td>
                                            <td>2</td>
                                            <td>${createdTime(trans.createdAt)}</td>
                                        </tr>
                                    `)
                                    $('#phoneCard-thead').html(`
                                        <tr>
                                            <th scope="col">phone card id</th>
                                            <th scope="col">mobie network operator</th>
                                            <th scope="col">phone card type</th>
                                        </tr>
                                    `)
                                    $('#phoneCard-tbody').html(listCard.map(card => {
                                        return `
                                            <tr>
                                                <th scope="col">${card.phoneCard_id}</th>
                                                <th scope="col">${card.mno}</th>
                                                <th scope="col">${card.phoneCardType}</th>
                                            </tr>
                                        `
                                    }))
                                } else {
                                    console.log('error')
                                }
                            })
                    } else if (trans.type_transaction == "1") {
                        $('#transaction-thead').html(`
                            <th scope="col">transaction id</th>
                            <th scope="col">transaction type</th>
                            <th scope="col">email</th>
                            <th scope="col">money</th>
                            <th scope="col">created At</th>
                            <th scope="col">card id</th>
                            <th scope="col">expired day</th>
                            <th scope="col">ccv</th>
                        `)
                        $('#transaction-tbody').html(`
                            <tr>
                                <th scope="row">${trans.transaction_id}</th>
                                <td>recharge transaction</td>
                                <td>${trans.email}</td>
                                <td>${trans.value_money}</td>
                                <td>${createdTime(trans.createdAt)}</td>
                                <td>111111</td>
                                <td>10/10/2022</td>
                                <td>411</td>
                            </tr>
                        `)
                        $('#phoneCard-thead').html(``)
                        $('#phoneCard-tbody').html(``)
                    } else if (trans.type_transaction == "2") {
                        $('#transaction-thead').html(`
                            <th scope="col">transaction id</th>
                            <th scope="col">type_transaction</th>
                            <th scope="col">email</th>
                            <th scope="col">phoneRecipient</th>
                            <th scope="col">money</th>
                            <th scope="col">costBearer</th>
                            <th scope="col">description</th>
                            <th scope="col">createdAt</th>
                        `)
                        $('#transaction-tbody').html(`
                            <tr>
                                <th scope="row">${trans.transaction_id}</th>
                                <td>transfer transaction</td>
                                <td>${trans.email}</td>
                                <td>${trans.phoneRecipient}</td>
                                <td>${trans.value_money}</td>
                                <td>${trans.costBearer}</td>
                                <td>${trans.description}</td>
                                <td>${createdTime(trans.createdAt)}</td>
                            </tr>
                        `)
                        $('#phoneCard-thead').html(``)
                        $('#phoneCard-tbody').html(``)
                    } else {
                        $('#transaction-thead').html(`
                            <th scope="col">transaction id</th>
                            <th scope="col">type_transaction</th>
                            <th scope="col">email</th>
                            <th scope="col">money</th>
                            <th scope="col">description</th>
                            <th scope="col">createdAt</th>
                        `)
                        $('#transaction-tbody').html(`
                            <tr>
                                <th scope="row">${trans.transaction_id}</th>
                                <td>withdraw transaction</td>
                                <td>${trans.email}</td>
                                <td>${trans.value_money}</td>
                                <td>${trans.description}</td>
                                <td>${createdTime(trans.createdAt)}</td>
                            </tr>
                        `)
                        $('#phoneCard-thead').html(``)
                        $('#phoneCard-tbody').html(``)
                    }
                }
            })
    }

    function createdTime(time) {
        const createdTime = new Date(time * 1000)
        const createdString = createdTime.getDate() +
            "/" + (createdTime.getMonth() + 1) +
            "/" + createdTime.getFullYear() +
            " " + createdTime.getHours() +
            ":" + createdTime.getMinutes() +
            ":" + createdTime.getSeconds()
        return createdString
    }
</script>