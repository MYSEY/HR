<div id="PermanentAddress">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Province/City</label>
                <select class="form-control" @change="cityChange" name="permanent_province" v-model="frm.city" :disabled="JSON.stringify(cities).length==2" value="{{old('city')}}">
                    <option v-for="(item,text) in cities" :value="text">@{{item}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>District/Khan</label>
                <select class="form-control" @change="districChange" name="permanent_district" v-model="frm.distric" :disabled="JSON.stringify(districs).length==2" value="{{old('distric')}}">
                    <option v-for="(item, text) in districs" :value="text">@{{item}}</option>
                </select>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group ">
                <label class="no-error-label">Commune/Sangkat</label>
                <select class="form-control no-error-border" @change="communeChange" name="permanent_commune" v-model="frm.commune" :disabled="JSON.stringify(communes).length==2" value="{{old('commune')}}">
                    <option v-for="(item, text) in communes" :value="text">@{{item}}</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="no-error-label">Village</label>
                <select class="form-control no-error-border" @change="villageChange" name="permanent_village" v-model="frm.village" :disabled="JSON.stringify(villages).length==2" value="{{old('village')}}">
                    <option v-for="(item, text) in villages" :value="text">@{{item}}</option>
                </select>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        var main = new Vue({
            el: '#PermanentAddress',
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
            }
        });
    });
</script>
