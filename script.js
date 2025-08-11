const mainH1 = document.getElementById("first-h1")
console.log(mainH1.innerHTML)


let inputs ={}

const inputField1 = document.getElementById("input-field-1")
const inputField2 = document.getElementById("input-field-2")
inputField1.addEventListener("change", (e) => {
    inputs["input-field-1"] = e.target.value
    console.log(inputs)  

})
inputField2.addEventListener("change", (e) => {
    inputs["input-field-2"] = e.target.value
    console.log(inputs)  

})

const formBtn = document.getElementById("form-btn")
formBtn.addEventListener("click", (e) => {
mainH1.innerHTML = inputs["input-field-1"] + " " + inputs["input-field-2"]
e.preventDefault()
})