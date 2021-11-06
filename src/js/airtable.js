import axios from "axios";

export default class Airtable { 

    constructor(prefix) {
        this.prefix = prefix;
    }

    companies(callback) {
        axios
        .get("/requests/?service=airtable&action=companies&prefix="+this.prefix)
        .then(response => callback(response))
        .catch(error => callback(error))
    }

    projects(id, callback) {
        axios
        .get("/requests/?service=airtable&action=projects&id="+id)
        .then(response => callback(response))
        .catch(error => callback(error))
    }

    teamMembers(id, callback) {
        axios
        .get("/requests/?service=airtable&action=team-members&id="+id)
        .then(response => callback(response))
        .catch(error => callback(error))
    }

}

