<link rel="stylesheet" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.carousel.min.css" type="text/css" />
<link rel="stylesheet" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.theme.default.min.css" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-body  ">
                <main class="ct-docs-content-col" role="main">
                    <div class="setup-openserver mb-4">
                        <h3 class="ct-docs-page-h3-title" ><?php echo isset($article['data']['title']) ? $article['data']['title'] : '' ?></h3>
                        <?php echo isset($article['data']['content']) ? $article['data']['content'] : '' ?>
                    </div>
                    <?php if(isset($article['data']['urlImages']) && is_array($article['data']['urlImages']) && count($article['data']['urlImages'])){ ?>
                      <h3 class="ct-docs-page-h3-title" >Album ảnh</h3>
                      <div class="galeri my-gallery">
                        <div class="owl-carousel owl-theme">
                          <?php foreach ($article['data']['urlImages'] as $value) { ?>
                            <div class="item">
                                <img src="<?php echo isset($value['src']) ? $value['src'] : $value ?>" alt="" />
                            </div>
                          <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if(isset($article['data']['rate']) && is_array($article['data']['rate']) && count($article['data']['rate'])){ ?>
                      <h3 class="ct-docs-page-h3-title" >Bình luận</h3>
                      <div class="comments">
                        <?php foreach ($article['data']['rate'] as $value) { ?>
                          <p>
                            <span class="text-primary text-bold"><?php echo $value['name'] ?></span>: 
                            <?php echo $value['comment'] ?>
                          </p>
                        <?php } ?>
                      </div>
                    <?php } ?>
                </main>
            </div>
        </div>
    </div>
</div>


<script>
  //owl2row plugin
;(function ($, window, document, undefined) {
    Owl2row = function (scope) {
        this.owl = scope;
        this.owl.options = $.extend({}, Owl2row.Defaults, this.owl.options);
        //link callback events with owl carousel here

        this.handlers = {
            'initialize.owl.carousel': $.proxy(function (e) {
                if (this.owl.settings.owl2row) {
                    this.build2row(this);
                }
            }, this)
        };

        this.owl.$element.on(this.handlers);
    };

    Owl2row.Defaults = {
        owl2row: false,
        owl2rowTarget: 'item',
        owl2rowContainer: 'owl2row-item',
        owl2rowDirection: 'utd' // ltr
    };

    //mehtods:
    Owl2row.prototype.build2row = function(thisScope){
    
        var carousel = $(thisScope.owl.$element);
        var carouselItems = carousel.find('.' + thisScope.owl.options.owl2rowTarget);

        var aEvenElements = [];
        var aOddElements = [];

        $.each(carouselItems, function (index, item) {
            if ( index % 2 === 0 ) {
                aEvenElements.push(item);
            } else {
                aOddElements.push(item);
            }
        });

        carousel.empty();

        switch (thisScope.owl.options.owl2rowDirection) {
            case 'ltr':
                thisScope.leftToright(thisScope, carousel, carouselItems);
                break;

            default :
                thisScope.upTodown(thisScope, aEvenElements, aOddElements, carousel);
        }

    };

    Owl2row.prototype.leftToright = function(thisScope, carousel, carouselItems){

        var o2wContainerClass = thisScope.owl.options.owl2rowContainer;
        var owlMargin = thisScope.owl.options.margin;

        var carouselItemsLength = carouselItems.length;

        var firsArr = [];
        var secondArr = [];

        //console.log(carouselItemsLength);

        if (carouselItemsLength %2 === 1) {
            carouselItemsLength = ((carouselItemsLength - 1)/2) + 1;
        } else {
            carouselItemsLength = carouselItemsLength/2;
        }

        //console.log(carouselItemsLength);

        $.each(carouselItems, function (index, item) {


            if (index < carouselItemsLength) {
                firsArr.push(item);
            } else {
                secondArr.push(item);
            }
        });

        $.each(firsArr, function (index, item) {
            var rowContainer = $('<div class="' + o2wContainerClass + '"/>');

            var firstRowElement = firsArr[index];
                firstRowElement.style.marginBottom = owlMargin + 'px';

            rowContainer
                .append(firstRowElement)
                .append(secondArr[index]);

            carousel.append(rowContainer);
        });

    };

    Owl2row.prototype.upTodown = function(thisScope, aEvenElements, aOddElements, carousel){

        var o2wContainerClass = thisScope.owl.options.owl2rowContainer;
        var owlMargin = thisScope.owl.options.margin;

        $.each(aEvenElements, function (index, item) {

            var rowContainer = $('<div class="' + o2wContainerClass + '"/>');
            var evenElement = aEvenElements[index];

            evenElement.style.marginBottom = owlMargin + 'px';

            rowContainer
                .append(evenElement)
                .append(aOddElements[index]);

            carousel.append(rowContainer);
        });
    };

    /**
     * Destroys the plugin.
     */
    Owl2row.prototype.destroy = function() {
        var handler, property;

        for (handler in this.handlers) {
            this.owl.dom.$el.off(handler, this.handlers[handler]);
        }
        for (property in Object.getOwnPropertyNames(this)) {
            typeof this[property] !== 'function' && (this[property] = null);
        }
    };

    $.fn.owlCarousel.Constructor.Plugins['owl2row'] = Owl2row;
})( window.Zepto || window.jQuery, window,  document );
//end of owl2row plugin

//init carousel
$(".owl-carousel").owlCarousel({
  loop: false,
  autoplay: true,
  owl2row: true,
  nav: true,
  dots:true
});
</script>

<style>
  .comments {
    margin: 50px auto;
    width: 800px;
    border-left: solid 2px #ccc;
    padding: 0px 20px 0px 20px;
} .comments p {
    background-color: #fff;
    padding: 10px;
    font-size: 16px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    border: solid 1px #ccc;
    line-height: 1.7;
    position: relative;
}
p::before {
    content: '';
    position: absolute;
    width: 10px;
    height: 10px;
    display: block;
    border: 3px solid #ccc;
    border-radius: 50%;
    background-color: #2c3e50;
    top: 10px;
    left: -30px;
}
p::after {
    content: '';
    position: absolute;
    border: solid 8px;
    border-color: transparent #ccc transparent transparent;
    top: 10px;
    left: -17px;
}
</style>