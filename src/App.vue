<template>
  <div id="app" :class="{ night: !dayLight }">
    <div class="sky">
      <span @click="toggleDay" class="sun"></span>
    </div>
    <div class="roof"></div>
    <div class="house">
      <div :class="[{ windows: true }, { day: dayLight }]"></div>
      <div :class="[{ door: true }, { day: dayLight }]"
           @click="requestCookie"></div>
      <div :class="[{ windows: true }, { day: dayLight }]"></div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'app',
  data (){
    return{
      dayLight: true,
      cookieURL: "http://localhost:8000/bakeCookie"
    }
  },
  methods:
  {
    toggleDay: function()
    {
      this.dayLight = !this.dayLight;
    },
    requestCookie: function()
    {
      if(!this.dayLight)
        return;
      
      const onSuccess = (data) => { window.alert("Got Cookie"); };
      const onError = (error) => { window.alert("Error: " + error); };

      fetch(this.cookieURL,
        {
          method: 'get',
          mode: 'cors',
          headers: { "Content-type": "application/json; charset=UTF-8"}
        })
        .then( (response) => response.json() )
        .then( (data) => onSuccess(data) )
        .catch( (error) => onError(error) );
    }
  }
}
</script>

<style lang="scss">
//dimensions
$sun-size: 100px;

$roof-height-size: 150px;
$roof-width-size: 300px;

$house-height-size: 250px;
$house-windows-size: 70px;
$house-door-height: 200px;
$house-door-width: 100px;

//house color
$house-color: #ccc;
$house-door-color: pink;

body
{
  width: 100%;
  position: absolute;
  margin: 0px;
}

#app 
{
  display: flex;
  flex-direction: column;
  align-items: center;
  background-color: white;
  width: 100%;
  height: 100%;
  margin-top: 20px;
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}

#app.night
{
  background-color: #3f51b5 !important;
}

.sky
{
  width: 100%;
  display: flex;
  justify-content: flex-end;
}

@mixin circle($circle-radius,$circle-color)
{
  height: $circle-radius;
  width: $circle-radius;
  background-color: $circle-color;
  border-radius: 50%;
  border: thin solid black;
  display: inline-block;
}

.sun
{
  @include circle($sun-size,rgb(255, 255, 0));
  cursor: pointer;
  margin-right: 20px;
}

.roof
{
  margin: auto;
  margin-top: 40px;
  margin-bottom: 0px;
  width: 0px;
  height: 0px;
  border-left: $roof-width-size solid transparent;
  border-right: $roof-width-size solid transparent;
  border-bottom: $roof-height-size solid $house-color;
}

@mixin rectangle($rect-height,$rect-width,$rect-color)
{
  width: $rect-width;
  height: $rect-height;
  background-color: $rect-color;
  border: thin solid black;
}

.house
{
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  @include rectangle($house-height-size,$roof-width-size * 2,$house-color);
}

.house .windows
{
  @include circle($house-windows-size,rgb(0, 174, 255));
  margin-top: 20px;
}

.house .windows.day:hover
{
  cursor: url(./assets/cookie-small.png), auto;
}

.house .door
{
  @include rectangle($house-door-height,$house-door-width,$house-door-color);
  border-bottom: hidden !important;
  align-self: flex-end;
}

.house .door.day:hover
{
  cursor: pointer;
}

</style>
