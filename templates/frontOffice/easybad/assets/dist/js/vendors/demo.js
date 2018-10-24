(function($) {

    "use strict";

    function buildRuleset() {

        // Start creating a new ruleset
        var ruleset = $.deps.createRuleset();
        
        
        var masterSwitchBad = ruleset.createRule("#projekt_art");
        
        /* Bad */
        
        var projektArtBad = masterSwitchBad.createRule("#projekt_art", "==", 2);
        projektArtBad.include(".bad-projekt-geraet");
        var badGeraet = projektArtBad.createRule("#bad-projekt-geraet", "any",new Array("2","3","4","5","6"));
        badGeraet.include(".bad-arbeit-typ");
        
        var badGeraetErsatzRepair = badGeraet.createRule("#bad-arbeit-typ", "any",new Array("2","3"));
        badGeraetErsatzRepair.include(".badMarke");
       badGeraetErsatzRepair.include(".badAnbieten"); 

        
        /* Küche */
       
        var projektArtKueche = masterSwitchBad.createRule("#projekt_art", "==", 3);
        projektArtKueche.include(".kueche-projekt-geraet");
        var kuecheGeraet = projektArtKueche.createRule("#kueche-projekt-geraet", "any",new Array("2","3","4","5"));
        kuecheGeraet.include(".kueche-arbeit-typ");
        var kuecheGeraetErsatzRepair = kuecheGeraet.createRule("#kueche-arbeit-typ", "any",new Array("2","3"));
        kuecheGeraetErsatzRepair.include(".kuecheMarke");
        kuecheGeraetErsatzRepair.include(".kuecheAnbieten");
        
         /* Heizung */
       
        var projektArtHeizung = masterSwitchBad.createRule("#projekt_art", "==", 4);
        projektArtHeizung.include(".heizung-projekt-geraet");
        var heizungGeraet = projektArtHeizung.createRule("#heizung-projekt-geraet", "any",new Array("2","3","4","5","6"));
        heizungGeraet.include(".heizung-arbeit-typ");
        var heizungGeraetErsatzRepair = heizungGeraet.createRule("#heizung-arbeit-typ", "any",new Array("2","3"));
        heizungGeraetErsatzRepair.include(".heizungMarke");
        heizungGeraetErsatzRepair.include(".heizungAnbieten");
        
        /* Warmwasser */
       
        var projektArtWarmwasser = masterSwitchBad.createRule("#projekt_art", "==", 5);
        projektArtWarmwasser.include(".warmwasser-projekt-geraet");
        var warmwasserGeraet = projektArtWarmwasser.createRule("#warmwasser-projekt-geraet", "any",new Array("2","3"));
        warmwasserGeraet.include(".warmwasser-arbeit-typ");
        var warmwasserGeraetErsatzRepair = warmwasserGeraet.createRule("#warmwasser-arbeit-typ", "any",new Array("2","3"));
        warmwasserGeraetErsatzRepair.include(".warmwasserMarke");
        warmwasserGeraetErsatzRepair.include(".warmwasserAnbieten");

        
        /* Andere Insallationen */
       
        var projektArtAndere = masterSwitchBad.createRule("#projekt_art", "==", 6);
        projektArtAndere.include(".andere-arbeit-typ");
        var andereGeraetErsatzRepair = projektArtAndere.createRule("#andere-arbeit-typ", "any",new Array("2","3"));
        andereGeraetErsatzRepair.include(".andereMarke");
        andereGeraetErsatzRepair.include(".andereAnbieten");
        
        

        /*var projektArtBadShower = projektArtBad.createRule("#bad-projekt-geraet", "==",3);
        
        var projektArtBadToiletShowerSinkPlumbing = projektArtBad.createRule("#bad-projekt-geraet", "any",new Array("2","3","4","5"));
        projektArtBadToiletShowerSinkPlumbing.include(".arbeit-typ");
        
        var projektArtBadShowerErsatz = projektArtBadShower.createRule("#arbeit-typ", "==",3);
        projektArtBadShowerErsatz.include(".bad-ersatz-unit");
        
        var projektArtBadSink = projektArtBad.createRule("#bad-projekt-geraet", "==",4);

        var projektArtBadPlumbing = projektArtBad.createRule("#bad-projekt-geraet", "==",5);
        var projektArtBadPlumbingOther = projektArtBad.createRule("#bad-projekt-geraet", "any",new Array("5","6"));
        projektArtBadPlumbingOther.include(".plumbing-appliance-type");

        
        var projektArtHeizung = masterSwitchBad.createRule("#projekt_art", "==", 4);
        projektArtHeizung.include(".heizung-projekt-geraet");
        
        var projektArtWaterHeater = masterSwitchBad.createRule("#projekt_art", "==", 5);
        projektArtWaterHeater.include(".water-heater-projekt-geraet");

        var projektArtWaterHeaterErsatz = projektArtWaterHeater.createRule("#water-heater-arbeit-typ", "==", 3);
        projektArtWaterHeaterErsatz.include(".baujahr");
        projektArtWaterHeaterErsatz.include(".hausgroesse");
        projektArtWaterHeaterErsatz.include(".pipe-material");
        projektArtWaterHeaterErsatz.include(".water-heater-location");
        projektArtWaterHeaterErsatz.include(".water-heater-age");
        projektArtWaterHeaterErsatz.include(".supply-water-heater");
        

        
        var supplyWaterHeater = projektArtWaterHeater.createRule("#supply-water-heater", "==", 2);
        supplyWaterHeater.include(".water-heater-type");
        supplyWaterHeater.include(".water-heater-capacity");
*/
        
        
        
        
        
        
        
        
        

        // Some sample pop-ups based on number input value

        var twoAttempts = masterSwitchBad.createRule("#numberOfAttempts", "==", 2);
        twoAttempts.include("#two-attempts-test");

        var threeAttempts = masterSwitchBad.createRule("#numberOfAttempts", "==", 3);
        threeAttempts.include("#three-attempts-test"); 

      



        // Check that <select> value equals our choice "yes"
        var angioplasty = masterSwitchBad.createRule("#angioplasty", "==", "yes");
        angioplasty.include(".datagridwidget-block-angioplastyExtraCranial");
        angioplasty.include(".datagridwidget-block-angioplastyIntraCranial");

        // Another <select> with nested options
        masterSwitchBad.include(".datagridwidget-block-adjunctiveStenting");
        var adjunctiveStenting = masterSwitchBad.createRule("#adjunctiveStenting", "==", "yes");
        adjunctiveStenting.include(".datagridwidget-block-adjunctiveStentingExtraCranial");
        adjunctiveStenting.include(".datagridwidget-block-adjunctiveStentingIntraCranial");

        // Then add some third level options which check against checboxes
        var adjunctiveStentingExtraCranial = adjunctiveStenting.createRule("#adjunctiveStentingExtraCranial", "==", true);
        adjunctiveStentingExtraCranial.include(".datagridwidget-block-adjunctiveStentingExtraCranialType");

        var adjunctiveStentingIntraCranial = adjunctiveStenting.createRule("#adjunctiveStentingIntraCranial", "==", true);
        adjunctiveStentingIntraCranial.include(".datagridwidget-block-adjunctiveStentingIntraCranialType");


        return ruleset;
    }

    $(document).ready(function() {

        var ruleset = buildRuleset();

        var cfg = {
            log : true
        };

        // Make ruleset effective on a selection
        // and start following changes in its inputs
        $.deps.enable($("#demo-content"), ruleset, cfg);

    });

})(jQuery);