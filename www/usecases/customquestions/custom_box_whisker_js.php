<?php
    header('Content-Type: application/javascript; charset=utf-8' );
?>
LearnosityAmd.define([
    'jquery-v1.10.2',
    'require-v2.1.9',
    'underscore-v1.5.2',
    '//<?php echo $_SERVER['HTTP_HOST']; ?>/usecases/customquestions/custom_box_whisker_d3.js'
], function ($, require, _, theD3) {
    'use strict';

    var d3 = theD3;

    if (!d3) throw 'D3 cannot be loaded';

    var padding = 10;
    var defaults = {
        "type": "custom",
        "stimulus": "Draw a <b>box &amp; whisker</b> chart for the following: <b>6, 2, 5, 3, 6, 10, 11, 6</b>",
        "params_line_min"      :       0,
        "params_line_max"      :       17,
        "params_step"          :       0.5,
        "params_mark_small"    :       0,
        "params_mark_big"      :       1,
        "params_width"         :       550,
        "params_height"        :       400,
        "params_range_1"       :       2,
        "params_range_2"       :       14,
        "params_quartile_1"    :       4,
        "params_median"        :       6,
        "params_quartile_3"    :       10,
        "params_box1_color"    :       "#9ae5c9",
        "params_box2_color"    :       "#9ae5c9",
        "valid_range_1"        :       2,
        "valid_range_2"        :       11,
        "valid_quartile_1"     :       4,
        "valid_median"         :       6,
        "valid_quartile_3"     :       8.5,
        "score": 1
    };

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//

    var u2x = (function (_) {
        var helper = {};

        var
            startX
            ,endX
            ,xPerUnit
            ,step
            ,params = {}
            ,valids = {}
            ,key
            ;

        helper.init = function( defaults, options, padding){
            for(key in defaults) {
                if(typeof(options[key]) == 'undefined' || options[key] == null) {
                    options[key] = defaults[key];
                }
            }

            for (key in options) {
                if (key.indexOf('params_') > -1) {
                    params[key.split('params_')[1]] = options[key];
                }
            }

            for (key in options) {
                if (key.indexOf('valid_') > -1) {
                    valids[key.split('valid_')[1]] = options[key];
                }
            }

            startX = padding
            endX = params.width - padding;
            xPerUnit = (endX - startX) / (params.line_max - params.line_min);
            step = params.step;
        }

        Object.defineProperty(helper, 'xPerUnit', {get: function(){
            return xPerUnit;
        }});

        Object.defineProperty(helper, 'params', {get:function(){
            return params;
        }});

        Object.defineProperty(helper, 'valids', {get:function(){
            return valids;
        }});

        helper.xToUnit = function(xVal){
            return Math.round((xVal - startX)/xPerUnit / step) * step + params.line_min;
        }

        helper.unitToX = function(uVal){
            return Math.round((uVal - params.line_min) * xPerUnit + startX);
        }

        helper.nearFactory =  function(quantum){
            var min = quantum;

            return function(v1) {
                return v1 <= min;
            };
        };

        helper.boolReducer = function(arr) {
            var trace = [];
            var result = _.reduce(arr, function(memo, e){
                trace.push({memo:memo, e:e});

                if (memo == false) return false;
                else if (typeof(e) === 'undefined' || e === null) return true;
                else if (e == false) return false;
                else return false;

            }, true);

            // console.log('-----boolReducer------');
            // console.log(arr);
            // console.log(trace);
            // console.log(result);
            // console.log('-----[[[[[]]]]]------');

            return result;
        };

        helper.XRemover = function(label) {
            var arr = label.split(' ');
            for ( ;_.last(arr) == 'X'; arr = arr.splice(0, arr.length - 1)) {

            }
            return arr.join(' ');
        };

        return helper;
    })(_);

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//

    var pubsub = (function(){

        var
            pack = {},
            topics = {
                'dragging range_1'     :   'dragging range_1'
                ,'dragging quartile_1'  :   'dragging quartile_1'
                ,'dragging median'      :   'dragging median'
                ,'dragging quartile_3'  :   'dragging quartile_3'
                ,'dragging range_2'     :   'dragging range_2'
                ,'lowerLimit reached'   :   'lowerLimit reached'
                ,'upperLimit reached'   :   'upperLimit reached'
                ,'intend to drag range_1'   :   'intend to drag range_1'
                ,'intend to drag quartile_1':   'intend to drag quartile_1'
                ,'intend to drag median'    :   'intend to drag median'
                ,'intend to drag quartile_3':   'intend to drag quartile_3'
                ,'intend to drag range_2'   :   'intend to drag range_2'
                ,'drag ended range_1'       :   'drag ended range_1'
                ,'drag ended quartile_1'    :   'drag ended quartile_1'
                ,'drag ended median'        :   'drag ended median'
                ,'drag ended quartile_3'    :   'drag ended quartile_3'
                ,'drag ended range_2'       :   'drag ended range_2'

            }
            ;

        pack.topics = topics;

        pack._topics = {};

        pack.subscribe = function(topic, listener){
            //console.log('sub ' + topic);

            if(!pack._topics[topic]) pack._topics[topic] = {queue: []};

            var index = pack._topics[topic].queue.push(listener) - 1;
            return {
                remove: function(){
                    if (index === -1) return;
                    delete pack._topics[topic].queue[index];
                    index = -1;
                }
            };
        };

        pack.publish = function(topic, info){
            if(!pack._topics[topic] || !pack._topics[topic].queue.length) {
                //console.log(!self._topics[topic] + ' --> ' + topic);
                //console.log(!self._topics[topic].queue.length);
                return;}

            var listeners = pack._topics[topic].queue;
            var feedback = [];
            listeners.forEach(function(e){
                feedback.push(e(info || {}));
            });
            //console.log('pub ' + topic);
            return feedback;
        };

        return pack;

    })();



    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//

    var handleDragBhvrFactory = (function(d3, pubsub, u2x){

        return function( vis ){



            // http://bl.ocks.org/enjalot/1378144
            return d3.behavior.drag()
                .on('drag', function(d, i) {
                    var
                    // destX = viewStep > 0 ? (Math.round( (d3.event.x) / viewStep ) * viewStep + '') : ((d3.event.x) + '')
                        destX = u2x.unitToX( u2x.xToUnit(d3.event.x) )
                        ,target = d3.select(this)
                        ,dataWho = target.attr('data-who')
                        ,response
                        ;

                    // move circle
                    if (   target.attr('old_cx')
                        &&  Math.abs(target.attr('old_cx') - d3.event.x) < u2x.xPerUnit / 3
                    )
                    {
                        return;
                    }

                    response = u2x.boolReducer( pubsub.publish(pubsub.topics['intend to drag ' + dataWho], {viewX: Number(destX), caller:[dataWho]}) );

                    if(!response) {

                        return false;
                    }

                    target
                        .attr('old_cx', target.attr('cx'))
                        .attr('cx', destX)
                    ;

                    pubsub.publish(
                        pubsub.topics['dragging ' + dataWho]
                        ,{
                            oldViewX    :   target.attr('old_cx')
                            ,viewX       :   target.attr('cx')
                        }
                    );

                })
                .on('dragend', function(d, i){
                    pubsub.publish(pubsub.topics['drag ended ' + d.who]);
                })
                ;

        };

    })(d3, pubsub, u2x);

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//

    var drawHandle = (function(d3, _, pubsub, u2x, handleDragBhvrFactory){
        var
            pack,
            intendtodragFactory = function(dataWho, monitorList, minDelta, maxDelta, near){

                var funk = function(){

                    //console.log('maxDelta ' + maxDelta);

                    // listen to myself if i m range_*
                    if (dataWho.indexOf('range_') !== -1) {
                        pubsub.subscribe(pubsub.topics['intend to drag ' + dataWho], function(msg){

                            // if i m near the edge, i will return false
                            var
                                self = d3.select('circle.handle[data-who=\'' + dataWho + '\']'),
                                cx = msg.viewX
                            ;

                            //console.log('checking ' + msg.viewX);

                            if (msg.viewX < minDelta || msg.viewX > maxDelta) return false;
                        });
                    }

                    monitorList.forEach(function(mon){
                        pubsub.subscribe(pubsub.topics['intend to drag ' + mon.name], function(msg) {

                            // mon is my adjacent i am looking to see if s/he is colliding
                            // with me shld s/he moves
                            var
                                self = d3.select('circle.handle[data-who=\'' + dataWho + '\']')
                                ,response = null
                                ,diff
                                ,cx
                                ;

                            // discontinue if i m already firing this chain of intend to drag
                            if (_.contains(msg.caller, dataWho)) {
                                return;
                            }

                            // the mouse position may be too far BEYOND the adjacent
                            diff = Number(self.attr('cx')) - msg.viewX;
                            if (mon.placeAt === 'right') {
                                cx = msg.viewX - minDelta;
                                diff *= -1;
                            }
                            else
                            if (mon.placeAt === 'left') {
                                cx = msg.viewX + minDelta;
                                diff *= 1;
                            }
                            else
                                throw ('mon.placeAt unknown --> ' + mon.placeAt);

                            if (near(diff)) {

                                // since i m changing position
                                // i wld wan to call intend to drag again
                                response = u2x.boolReducer(
                                    pubsub.publish(
                                        pubsub.topics['intend to drag ' + dataWho ]
                                        ,{
                                            viewX:cx
                                            ,caller:_.union(msg.caller,[dataWho])
                                        })
                                );

                                if (!response) {
                                    return false;
                                }

                                // ok to drag
                                self.attr('old_cx', self.attr('cx')).attr('cx', cx);
                                pubsub.publish(pubsub.topics['dragging ' + dataWho], {
                                    oldViewX:self.attr('old_cx')
                                    ,viewX:self.attr('cx')
                                });
                            }
                        });
                    });


                };

                funk();

            }
            ;

        pack = function(canvas, bnw, startX, yOffset, handleSize, params){
            bnw.selectAll('circle.handle').data([
                {
                    x: u2x.unitToX(params.range_1)
                    ,y: yOffset
                    ,r: handleSize
                    ,who: 'range_1'
                }
                ,
                {
                    x: u2x.unitToX(params.quartile_1)
                    ,y: yOffset
                    ,r: handleSize
                    ,who: 'quartile_1'
                }
                ,
                {
                    x: u2x.unitToX(params.median)
                    ,y: yOffset
                    ,r: handleSize
                    ,who: 'median'
                }
                ,
                {
                    x: u2x.unitToX(params.quartile_3)
                    ,y: yOffset
                    ,r: handleSize
                    ,who: 'quartile_3'
                }
                ,
                {
                    x: u2x.unitToX(params.range_2)
                    ,y: yOffset
                    ,r: handleSize
                    ,who: 'range_2'
                }
            ])
                .enter()
                .append('svg:circle')
                .attr('cx', function(d){return d.x;})
                .attr('cy', function(d){return d.y;})
                .attr('r', function(d){return d.r;})
                .attr('data-who', function(d){return d.who;})
                .classed('handle', true)
                .on('mouseover', function(d,i){
                    // find my circle.handle, put in a selected class
                    bnw.selectAll('circle.handle')
                        .classed('selected', function(e, j){
                            return i === j;
                        })
                    ;

                    bnw.selectAll('line.rangeLine')
                        .classed('selected', function(e, j){
                            return i === j;
                        })
                    ;
                })
                .on('mouseout', function(d,i){
                    // find my circle.handle.selected remove selected class
                    bnw.selectAll('circle.handle')
                        .classed('selected', function(e, j){
                            if (i === j) return false; // we only remove what we set
                        })
                    ;

                    bnw.selectAll('line.rangeLine')
                        .classed('selected', function(e, j){
                            if (i === j) return false; // we only remove what we set
                        })
                    ;
                })
                //.call(handleDragBhvrFactory( canvas, unitGap * ( params.step ? params.step : 0 ), params.step ))
                .call(handleDragBhvrFactory( canvas ))
                .call(function(sa){
                    var
                        minDelta = u2x.xPerUnit * params.step
                        ,maxDelta = (params.line_max + params.step) * u2x.xPerUnit
                        ,near = u2x.nearFactory(minDelta / 2)
                        ;

                    sa[0].forEach( function(c){
                        var dataWho = d3.select(c).attr('data-who');
                        ////console.log(e);
                        switch (dataWho) {
                            case 'range_1':

                                intendtodragFactory(dataWho, [{name:'quartile_1', placeAt:'right'}], minDelta, maxDelta, near);

                                break;
                            case 'quartile_1':

                                intendtodragFactory(dataWho, [{name:'range_1', placeAt:'left'}, {name:'median', placeAt:'right'}], minDelta, maxDelta, near);

                                break;
                            case 'median':

                                intendtodragFactory(dataWho, [{name:'quartile_1', placeAt:'left'},{name:'quartile_3', placeAt:'right'}], minDelta, maxDelta, near);

                                break;
                            case 'quartile_3':

                                intendtodragFactory(dataWho, [{name:'median',placeAt:
                                    'left'},{name:'range_2',placeAt:'right'}], minDelta, maxDelta, near);

                                break;
                            case 'range_2':

                                intendtodragFactory(dataWho, [{name:'quartile_3',placeAt:'left'}], minDelta, maxDelta, near);

                                break;
                        }

                    });
                })
            ;
        };


        return pack;

    })( d3, _, pubsub, u2x, handleDragBhvrFactory);


    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//

    var drawFeedback = (function(d3, pubsub, u2x){

        var pack = {};

        pack.formatter = d3.format(',.1f');

        pack.drawOne = function(vis, name, insertion){
            var
                subscription
                ;

            vis.selectAll('text.feedback' + '[data-who=\'' + name + '\']' )
                .data([insertion])
                .enter()
                .append('svg:text')
                .attr('x', insertion.destX)
                .attr('y', insertion.destY)
                .attr('dy', '.71em')
                .attr('style', 'text-anchor: middle; font-size: 10px;')
                .attr('data-who', name)
                .classed('feedback', true)
                .text(pack.formatter( u2x.xToUnit(insertion.destX) ) )
            ;

            subscription =
                pubsub.subscribe('dragging ' + name, function(msg){
                    var
                        self = vis.select('text.feedback' + '[data-who=\'' + name + '\']')
                        ,revive = function(){

                            var handle = d3.select('circle.handle[data-who=\''+ name +'\']');

                            pack.drawOne( vis, name, {
                                destX: handle.attr('cx')
                                ,destY: insertion.destY
                                ,viewStep: insertion.viewStep
                                ,dataStep: insertion.dataStep
                                ,params: insertion.params
                            } );
                        }
                        ,TOhandle
                        ;


                    if (self.empty()) {
                        return;
                    }

                    self.remove();
                    subscription.remove();
                    //delete subscriptionMap[name];
                    TOhandle = setTimeout(revive, 200);
                });
        };

        pack.drawAll = function(bnw, startX, yOffset, fbOffset, params){
            var
                viewStep = u2x.xPerUnit
                ,dataStep = params.step
                ,destY = yOffset - fbOffset
                ;

            [
                {
                    name: 'range_1'
                    ,insertion: {
                    destX: u2x.unitToX(params.range_1)//Math.round((startX + unitGap * params.range_1)/viewStep) * viewStep
                    ,destY: destY
                    ,viewStep: viewStep
                    ,dataStep: dataStep
                }
                }
                ,{
                name: 'quartile_1'
                ,insertion: {
                    destX: u2x.unitToX(params.quartile_1)//Math.round((startX + unitGap * params.quartile_1)/viewStep) * viewStep
                    ,destY: destY
                    ,viewStep: viewStep
                    ,dataStep: dataStep
                }
            }
                ,{
                name: 'median'
                ,insertion: {
                    destX: u2x.unitToX(params.median)//Math.round((startX + unitGap * params.median)/viewStep) * viewStep
                    ,destY: destY
                    ,viewStep: viewStep
                    ,dataStep: dataStep
                }
            }
                ,{
                name: 'quartile_3'
                ,insertion: {
                    destX: u2x.unitToX(params.quartile_3)//Math.round((startX + unitGap * params.quartile_3)/viewStep) * viewStep
                    ,destY: destY
                    ,viewStep: viewStep
                    ,dataStep: dataStep
                }
            }
                ,{
                name: 'range_2'
                ,insertion: {
                    destX: u2x.unitToX(params.range_2)//Math.round((startX + unitGap * params.range_2)/viewStep) * viewStep
                    ,destY: destY
                    ,viewStep: viewStep
                    ,dataStep: dataStep
                }
            }
            ].forEach(function(e){
                    pack.drawOne(bnw, e.name, e.insertion);
                });
        };



        return pack;
    })(d3, pubsub, u2x);

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//

    var drawRangeLine = (function(pubsub, u2x){
        return function(bnw, startX, yOffset, boxThickness, params){
            bnw.selectAll('line.rangeLine').data([
                { x:u2x.unitToX(params.range_1)      , y:yOffset     , who:'range_1' } // range_1
                ,{ x:u2x.unitToX(params.quartile_1)   , y:yOffset     , who:'quartile_1' } // quartile_1
                ,{ x:u2x.unitToX(params.median)       , y:yOffset     , who:'median' } // median
                ,{ x:u2x.unitToX(params.quartile_3)   , y:yOffset     , who:'quartile_3' } // quartile_3
                ,{ x:u2x.unitToX(params.range_2)      , y:yOffset     , who:'range_2' } // range_2
            ])
                .enter()
                .append('svg:line')
                .attr('x1', function(d){ /*console.log('x1 -> ' + d.x);*/  return d.x;})
                .attr('y1', function(d){return d.y - boxThickness;})
                .attr('x2', function(d){return d.x;})
                .attr('y2', function(d){return d.y + boxThickness;})
                .attr('data-who', function(d){return d.who;})
                .classed('rangeLine', true)
                .each(function(d){
                    var d3Self = this;
                    pubsub.subscribe(pubsub.topics['dragging ' + d.who], function(msg){
                        d3.select(d3Self).attr('x1',msg.viewX).attr('x2',msg.viewX);
                    });

                })

            ;};
    })(pubsub, u2x);

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//

    var drawBox = (function(d3, pubsub, u2x){
        var
            topics = pubsub.topics,
            pack = {}
            ;

        pack = function(bnw, startX, yOffset, boxThickness, params){
            bnw.selectAll('rect.box').data([
                {
                    l: u2x.unitToX(params.quartile_1)
                    ,t: yOffset - boxThickness
                    ,r: u2x.unitToX(params.median)
                    ,b: yOffset + boxThickness
                    ,who: 'quartile_1--median'
                    ,fill: params.box1_color
                }
                ,
                {
                    l: u2x.unitToX(params.median)
                    ,t: yOffset - boxThickness
                    ,r: u2x.unitToX(params.quartile_3)
                    ,b: yOffset + boxThickness
                    ,who: 'median--quartile_3'
                    ,fill: params.box2_color
                }
            ])
                .enter()
                .append('svg:rect')
                .attr('x', function(d){return d.l;})
                .attr('y', function(d){return d.t;})
                .attr('width', function(d){return d.r-d.l;})
                .attr('height', function(d){return d.b-d.t;})
                .attr('data-who', function(d){return d.who;})
                .attr('fill', function(d){if (d.fill) {return d.fill;}})
                .classed('box', true)
                .each(function(d){
                    var
                        type1FunkFactory = function(who) {
                            return function(msg) {
                                var
                                    self = d3.select('rect.box[data-who=\'' + who + '\']')
                                    ,x1 = Number(self.attr('x'))
                                    ,x2 = x1 + Number(self.attr('width'))
                                    ;

                                self.attr('x', msg.viewX)
                                    .attr('width', x2 - msg.viewX)
                                ;
                            };
                        }
                        ,type2FunkFactory = function(who) {
                            return function(msg) {
                                var
                                    self = d3.select('rect.box[data-who=\'' + who + '\']')
                                    ,x1 = Number(self.attr('x'))
                                    ,x2 = x1 + Number(self.attr('width'))
                                    ;

                                self.attr('x', x1)
                                    .attr('width', msg.viewX - x1)
                                ;
                            };
                        }
                        ,handlers = {
                            'quartile_1--median' : {
                                'quartile_1' : type1FunkFactory
                                ,'median' : type2FunkFactory
                            }
                            ,'median--quartile_3' : {
                                'median' : type1FunkFactory
                                ,'quartile_3' : type2FunkFactory
                            }
                        }
                        ;

                    //var sel = d3.select(box).attr('data-who');
                    d.who.split('--').forEach(function(handleName){
                        pubsub.subscribe(topics['dragging ' + handleName], handlers[d.who][handleName](d.who));
                    });
                })
            ;
        };

        return pack;

    })(d3, pubsub, u2x);

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//

    var drawWhisker = (function(d3, pubsub, u2x){
        var
            topics = pubsub.topics,
            pack = {}
            ;

        pack = function(bnw, startX, yOffset, params){
            // whisker

            bnw.selectAll('line.whisker').data([
                {
                    xStart:u2x.unitToX(params.range_1)
                    ,xEnd: u2x.unitToX(params.quartile_1)
                    ,y:yOffset
                    ,who: 'range_1--quartile_1'
                } // whisker_1
                ,{
                    xStart:u2x.unitToX(params.quartile_3)
                    ,xEnd: u2x.unitToX(params.range_2)
                    ,y:yOffset
                    ,who: 'quartile_3--range_2'
                } // whisker_2
            ])
                .enter()
                .append('svg:line')
                .attr('x1', function(d){return d.xStart;})
                .attr('y1', function(d){return d.y;})
                .attr('x2', function(d){return d.xEnd;})
                .attr('y2', function(d){return d.y;})
                .attr('data-who', function(d){return d.who;})
                .classed('whisker', true)
                .each(function(d){
                    var
                        funkFactory = function(who, x) {
                            var
                                pack
                                ;

                            pack = function(msg){
                                var self = d3.select('line.whisker[data-who=\'' + who + '\']');
                                self.attr(x, msg.viewX);
                            };

                            return pack;
                        }
                        ,handle2X = {
                            'range_1':'x1'
                            ,'quartile_1':'x2'
                            ,'quartile_3':'x1'
                            ,'range_2':'x2'
                        }
                        ;

                    d.who.split('--').forEach(function(handleName){
                        pubsub.subscribe(topics['dragging ' + handleName], funkFactory(d.who, handle2X[handleName]));
                    });
                })
            ;
        };

        return pack;

    })(d3, pubsub, u2x);

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//

    var drawBnW = (function(
        d3,
        pubsub,
        u2x,
        drawWhisker,
        drawBox,
        drawRangeLine,
        drawFeedback,
        drawHandle
    ){

        return function(vis, params, padding, yOffset){
            var
                bnw
                ,startX = padding
                ,endX = params.width - padding
                ,unitGap = u2x.xPerUnit
                ,unitCount = (endX-startX) / unitGap//,yOffset = 50
                ,handleSize = 7
                ,boxThickness = 60
                ,fbOffset = 40
                ;

            boxThickness /= 2;

            bnw = vis.append('g');
            bnw.classed('boxnwhisker', true);

            //console.log('unitCount ' + unitCount);

            // whisker
            drawWhisker(bnw, startX, yOffset, params);

            // box
            drawBox(bnw, startX, yOffset, boxThickness, params);

            // range_X line
            drawRangeLine(bnw, startX, yOffset, boxThickness, params);


            // range_x feedback
            drawFeedback.drawAll(bnw, startX, yOffset, fbOffset, params);

            // handle
            drawHandle(vis, bnw, startX, yOffset, handleSize, params);

            return bnw;
        };

    })(d3, pubsub, u2x, drawWhisker, drawBox, drawRangeLine, drawFeedback, drawHandle);

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//

    var drawAxes = (function(){
        var drawAxes = {};

        drawAxes.makeArrowDef = function(vis){
            // Per-type markers, as they don't inherit styles.
            vis.append("defs").append("marker")
                .attr("id", "arrow")
                .attr("viewBox", "0 -5 10 10")
                .attr("refX", 0)
                .attr("refY", 0)
                .attr("markerWidth", 6)
                .attr("markerHeight", 6)
                .attr("orient", "auto")
                .append("path")
                .attr("d", "M0,-5L10,0L0,5")
            ;
        };

        drawAxes.drawArrows = function(vis, params, padding, yOffset){
            var
                left = vis.selectAll('line.arrowHead.begin')
                ,right = vis.selectAll('line.arrowHead.end')
                ;

            left.data([0])
                .enter() // doing this coz i m looking to INIT a arrow
                .append('svg:line')
                .attr('class', 'arrowHead begin')
                .attr('marker-end', 'url(#arrow)')
                .attr('x1', padding + 1)
                .attr('y1', yOffset)
                .attr('x2', 6)
                .attr('y2', yOffset)
            ;

            right.data([0])
                .enter()
                .append('svg:line')
                .attr('class', 'arrowHead end')
                .attr('marker-end', 'url(#arrow)')
                .attr('x1', params.width - padding - 1)
                .attr('y1', yOffset)
                .attr('x2', params.width - 6)
                .attr('y2', yOffset)
            ;
        };

        drawAxes.drawXAxes = function(vis, params, padding, yOffset){
            var
            //Create the Scale we will use for the Axis
                axisScale = d3.scale.linear()
                    .domain([params.line_min, params.line_max])
                    .range([padding, params.width-padding]) // Y is [max, min], X is [min, max]

                ,ticksGen = function(step){
                    var
                        i
                        ,out = []
                        ;

                    for(i = params.line_min; i <= params.line_max; i+=step) {
                        out.push(i);
                    }

                    //console.log(out);
                    return out;
                }

                ,tickValues1 = ticksGen(params.mark_big)
                ,tickValues2 = params.mark_small > 0 ?
                    _.filter(ticksGen(params.mark_small),
                        function(e){
                            return _.contains(tickValues1, e) == false;
                        })
                    : []

                ;
            //console.log(tickValues2);

            var orient = 'bottom'
                ,tickSize1 = 9
                ,tickSize2 = 3

            //Create the Scale we will use for the Axis
                ,xAxis1 = d3.svg.axis()
                    .scale(axisScale)
                    .orient(orient)
                    .tickSize(tickSize1, tickSize1)
                    .tickValues(tickValues1)

            //Create the Scale we will use for the Axis
                ,xAxis2 = params.mark_small > 0 ?
                    d3.svg.axis()
                        .scale(axisScale)
                        .orient(orient)
                        .tickSize(tickSize2, tickSize2)
                        .tickFormat(d3.format(",.1f"))
                        .tickValues(tickValues2)
                    : null

            //Create a group Element for the Axis elements and call the xAxis function
                ,xAxisGroup1 = vis.append("g")
                    .attr('transform', 'translate(0, ' + yOffset + ')')
                    .attr('class', 'x axis long')
                    .call(xAxis1)

            //Create a group Element for the Axis elements and call the xAxis function
                ,xAxisGroup2 = params.mark_small > 0 ?
                    vis.append("g")
                        .attr('transform', 'translate(0, ' + yOffset + ')')
                        .attr('class', 'x axis short')
                        .call(xAxis2)
                    : null
                ;
        };

        return drawAxes;
    })();

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//

    var bnwQ = function(options) {

        var self = this;

        var makeArrowDef = drawAxes.makeArrowDef;
        var drawXAxes = drawAxes.drawXAxes;
        var drawArrows = drawAxes.drawArrows;
        var vis;
        var w = options.question.params_width;
        var h = options.question.params_height;
        var padding = 10;
        var triggerChanged = function(){
            options.events.trigger('changed', self.response);
        };
        var validate = function(){
            var
                scorer = new bnwS(options.question, self.response),
                whatsWrong = scorer.updateResponse().whatsWrong
                ;

            if(whatsWrong.length <= 0) {
                d3.selectAll('text.feedback')
                    .attr('fill', '#11aa00');
            }
            else {
                // feedback
                whatsWrong.forEach(function(w){
                    var select = d3.select('text.feedback' + '[data-who=\'' + w + '\']');
                    var selText = u2x.XRemover(select.text());

                    select.attr('fill', '#ee1100')
                        .attr('data-oldText', select.text())
                        .text(selText + ' X');
                });

            }
        };

        options.$el.html('');
        vis = d3.select(options.$el.get(0)).append('svg');
        u2x.init( defaults, options.question, padding );
        self.validate = validate;

        // define size of SVG cnavas
        vis.attr('width', options.question.params_width)
            .attr('height', options.question.params_height)
        ;

        makeArrowDef(vis);
        drawXAxes(vis, u2x.params, padding, 100);
        drawArrows(vis, u2x.params, padding, 100);
        drawBnW(vis, u2x.params, padding, 50);


        Object.defineProperty(self, 'response', {get : function(){
            // get all handles
            var valSet = {};
            d3.selectAll('circle.handle')
                .each(function(d, i){

                    var
                        val = u2x.xToUnit( Number(d3.select(this).attr('cx')) ),
                        dataWho = d.who
                        ;

                    valSet[dataWho] = val;
                });

            return valSet;
        }});

        [
            pubsub.topics['drag ended range_1'],
            pubsub.topics['drag ended quartile_1'],
            pubsub.topics['drag ended median'],
            pubsub.topics['drag ended quartile_3'],
            pubsub.topics['drag ended range_2']
        ].forEach(function(t){
                pubsub.subscribe(t, triggerChanged);
            });

        options.events.on('validate', function(){
            self.validate();
        });

        options.events.on('changed', function(){
            d3.selectAll('text.feedback').attr('fill', null)
                .each(function(d){
                    d3.select(this).text(u2x.XRemover(d3.select(this).text()));
                });
        });

        if (options.state === 'review') {
            self.validate();
        }

        options.events.trigger('ready');
        triggerChanged();

    };

    var bnwS = function (question, response) {
        var self = this;

        this.question = question;
        this.response = response;

        Object.defineProperty(this, 'whatsWrong', { get: function(){
            var
             pack = []
            ;

            if (self.response.range_1 != self.question.valid_range_1)
                pack.push('range_1');

            if (self.response.quartile_1 != self.question.valid_quartile_1)
                pack.push('quartile_1');

            if (self.response.median != self.question.valid_median)
                pack.push('median');

            if (self.response.quartile_3 != self.question.valid_quartile_3)
                pack.push('quartile_3');

            if (self.response.range_2 != self.question.valid_range_2)
                pack.push('range_2');

            return pack;
        }});
    };

    bnwS.prototype.updateResponse = function() {
        //this.response = response;
        return this;
    };

    bnwS.prototype.isValid = function() {

        return this.whatsWrong.length <= 0;
    };

    bnwS.prototype.score = function() {
        return this.isValid() ? this.maxScore() : 0;
    };

    bnwS.prototype.maxScore = function() {
        return this.question.score || 1;
    };

    return {
        Question: bnwQ,
        Scorer: bnwS//bnwQuestion.scorer
    };

});
