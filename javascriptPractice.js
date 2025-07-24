const duplicateArray = [1, 1, 2, 2, 3, 3, 4, 4, 5, 5];

// const removeDuplicate = (arr) => [...new Set(arr)];

// const newArr = removeDuplicate(duplicateArray);
// console.log(newArr);

// const findEven = (arr) => arr.filter((arr) => arr % 2 === 0);

// const even = findEven(duplicateArray);
// console.log(even);

// split and reverse string

const Aname = "john";
// const reverse = (str) => str.split("").reverse().join("");
// const rep = reverse(name);
// const join = (arr) => arr.reverse("");
// const matches = (str) => str.match(/[aeiou]/gi);
// const characterFreq = (str) => {
//   result = {
//     j: 2,
//   };
//   for (let char of str) {
//     result[char] = result[char] ? result[char] + 1 : 1;
//   }
//   return result;
// };
const user = [
  {
    name: "wilson",
    age: 24,
  },
  {
    name: "aliyah",
    age: 24,
  },
  {
    name: "guy",
    age: 20,
  },
];

// const separateUsersByAge = (users) => {
//   let grouped = {};
//   users.forEach(({ name, age }) => {
//     console.log(name);
//     if (!grouped[age]) grouped[age] = [];
//     grouped[age].push(name);
//   });
//   return grouped;
// };
// check palindrome
// const check = (value) => {
//   const str = value.toString();
//   const newStr = str.split("").reverse().join("");
//   return newStr === str;
// };
// const input = "the cat and the dog and the mouse";
// const mostFrequentWord = (arr) => {
//   const splitted = arr.split(" ");
//   const newList = {};
//   splitted.forEach((str) => {
//     !newList[str] ? (newList[str] = 1) : (newList[str] += 1);
//   });
//   let maxChar = null;
//   let maxCount = 0;
//   const newObj = newList;
//   console.log(newObj);

//   for (let char in newObj) {
//     if (newList[char] > maxCount) {
//       maxChar = char;
//       maxCount = newList[char];
//     }
//   }
//   return maxChar;
// };
const task = "the quick brown fox jumps over the lazy dog";
const longestWord = (str) => {
  const splitted = str.split(" ");
  const setIt = [...new Set(splitted)];
  console.log(setIt);
  let data = {};

  for (let char of setIt) {
    // data[char]=(data[char] || 0) + 1
    for (let sChar of char) {
      data[char] = (data[char] || 0) + 1;
    }
  }
  let maxChar = null;
  let maxCount = 0;
  for (let char in data) {
    if (data[char] > maxCount) {
      maxChar = char;
      maxCount = data[char];
    }
  }
  return maxChar;
};

console.log(longestWord("i love speed and style"));
