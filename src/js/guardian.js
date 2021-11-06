import config from '../js/config.js'
import Airtable from '../js/airtable.js'
import Harvest from '../js/harvest'

var guardian = {

    guard(to, from, next) {

        if (config.onHumanHarvestCompanyID === null) {

            var prefix = config.hostname.split(".");

            var airtable = new Airtable(prefix[0]);

            airtable.companies(

                function (companies) {

                    if(companies.data.error !== true) {

                    if (companies.data.records.length > 0) {

                        var company = companies.data.records[0];
                        var harvestCompanyID = company.fields['Harvest Company ID'];

                        config.onHumanHarvestCompanyID = harvestCompanyID;
                        
                        var companyWebsite = company.fields['Website'];
                        config.companyWebsite = companyWebsite;

                        var harvest = new Harvest(harvestCompanyID);

                        harvest.company(function (company) {

                            //console.log(company);

                            config.companyAddress = company.data.address;

                            localStorage.setItem("no_account", false);

                            config.loading = false;

                            next()

                        });

                    } else {

                        localStorage.setItem("no_account", true);


                        next();



                    }

                } else {
                    next("service-down");
                }

                }

            );

        } else {

            config.loading = false;
            next()



        }

    }

}

export default guardian