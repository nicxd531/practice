// start
const newFormData = new FormData();
if (poster) {
  newFormData.append("file", {
    uri: poster?.uri || "https://example.com/test.jpg",
    type: "image/jpeg",
    name: "test.jpg",
  });
}

try {
  const response = await fetch("https://httpbin.org/post", {
    method: "POST",
    body: newFormData,
  });
  console.log("Test upload successful");
} catch (error) {
  console.log("Test upload failed:", error);
}

// end
