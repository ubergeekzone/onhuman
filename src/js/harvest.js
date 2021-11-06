/* */

import axios from "axios";

export default class Harvest { 

    constructor(companyID) {
        this.companyID = companyID;
    }

     company(callback) {
        axios
        .get("/requests/?service=harvest&action=getClient&id="+this.companyID)
        .then(response => callback(response))
        .catch(error => callback(error))
    }

    contact(contactID, callback) {
        axios
        .get("/requests/?service=harvest&action=getContact&id="+contactID)
        .then(response => callback(response))
        .catch(error => callback(error))
    }

    
    contacts(callback) {
        axios
        .get("/requests/?service=harvest&action=listClientContacts&id="+this.companyID)
        .then(response => callback(response))
        .catch(error => callback(error))
    }

    projects(callback) {
        axios
        .get("/requests/?service=harvest&action=listProjects&id="+this.companyID)
        .then(response => callback(response))
        .catch(error => callback(error))
    }

    project(projectID, callback) {
        axios
        .get("/requests/?service=harvest&action=getProject&id="+projectID)
        .then(response => callback(response))
        .catch(error => callback(error))
    }

    user(userID, callback) {
        axios
        .get("/requests/?service=harvest&action=getUser&id="+userID)
        .then(response => callback(response))
        .catch(error => callback(error))
    }

    estimates(clientID, callback) {
        axios
        .get("/requests/?service=harvest&action=listEstimates&id="+clientID)
        .then(response => callback(response))
        .catch(error => callback(error))
    }

    invoices(clientID, projectID, callback) {
        axios
        .get("/requests/?service=harvest&action=listInvoices&id="+clientID+"&projectID="+projectID)
        .then(response => callback(response))
        .catch(error => callback(error))
    }

    expenses(clientID, projectID, callback) {
        axios
        .get("/requests/?service=harvest&action=listExpenses&id="+clientID+"&projectID="+projectID)
        .then(response => callback(response))
        .catch(error => callback(error))
    }


}

