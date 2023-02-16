<div class="form-group col-md-12">
    <div class="row" id="address">
        <div class="col-sm-6 col-md-6 mb-3">
            <label>Province/City</label>
            <select class="form-control" @change="cityChange" v-model="frm.city" :disabled="JSON.stringify(cities).length==2">
                <option v-for="(item,text) in cities" :value="text">@{{item}}</option>
            </select>
        </div>
        <div class="col-sm-6 col-md-6">
            <label>District/Khan</label>
            <select class="form-control" @change="districChange" v-model="frm.distric" :disabled="JSON.stringify(districs).length==2">
                <option v-for="(item, text) in districs" :value="text">@{{item}}</option>
            </select>
        </div>
        <div class="col-sm-6 col-md-6">
            <label class="no-error-label">Commune/Sangkat</label>
            <select class="form-control no-error-border" @change="communeChange" v-model="frm.commune" :disabled="JSON.stringify(communes).length==2">
                <option v-for="(item, text) in communes" :value="text">@{{item}}</option>
            </select>
        </div>
        <div class="col-sm-6 col-md-6">
            <label class="no-error-label">Village</label>
            <select class="form-control no-error-border" @change="villageChange" v-model="frm.village" :disabled="JSON.stringify(villages).length==2">
                <option v-for="(item, text) in villages" :value="text">@{{item}}</option>
            </select>
        </div>
        <input type="hidden" v-model="hidden" name="">
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
<script>

    window.onload = function () {
        var main = new Vue({
            el: '#address',
            data() {
                return {
                    cities:{},
                    districs:{},
                    communes:{},
                    villages:{},
                    frm:{},
                }
            },
            mounted() {
                this.getData();
            },
            methods:{
                cityChange: async function(){
                    var me = this;
                    this.hidden = this.frm.city;
                    await this.getData(this.frm.city).then(function(response){
                    me.districs = response.data;
                    me.communes={};
                    me.villages={};
                });
            },
            districChange: async function(){
                var me = this;
                this.hidden = this.frm.distric;
                await this.getData(this.frm.distric).then(function(response){
                    me.communes = response.data;
                    me.villages={};
                });
            },
            communeChange: async function(){
                var me = this;
                this.hidden = this.frm.commune;
                await this.getData(this.frm.commune).then(function(response){
                    me.villages = response.data;
                });
            },
            villageChange:function(){
                this.hidden = this.frm.village;
            },
            getData:function(code=''){
                if(code){ 
                    return axios.get('{{route("address")}}?code='+code)
                }
                else
                { 
                    return axios.get('{{route("address")}}')
                }
            }
        },
        
        created: async function(){
            var me = this;
            this.getData().then(function(response){
               me.cities = response.data;
            });

            // if(this.hidden.length>1){
            //     var str = this.hidden;
            //     var take = 2;
            //     var i = 1;

            //     do {
            //         var res = str.substring(0, take*i);
            //         if(i==1){
            //             this.frm.city=res;
            //             await this.cityChange();
            //         }
            //         if(i==2){
            //             this.frm.distric=res;
            //             await this.districChange();
            //         }
            //         if(i==3){
            //             this.frm.commune=res;
            //             await this.communeChange();
            //         }
            //         if(i==4){
            //             this.frm.village=res;
            //             await this.villageChange();
            //         }
            //         i++;
            //     } while (res!=str);
            // }
        }

        });
    }
</script>