import face_recognition
import sys
import json
import os

def verify_face(photo_path1, photo_path2):
    if not os.path.exists(photo_path1):
        return {"match": False, "error": f"Photo 1 does not exist: {photo_path1}"}
    if not os.path.exists(photo_path2):
        return {"match": False, "error": f"Photo 2 does not exist: {photo_path2}"}

    image1 = face_recognition.load_image_file(photo_path1)
    image2 = face_recognition.load_image_file(photo_path2)

    try:
        encoding1 = face_recognition.face_encodings(image1)[0]
        encoding2 = face_recognition.face_encodings(image2)[0]
    except IndexError:
        return {"match": False, "error": "No face found in one of the images"}

    results = face_recognition.compare_faces([encoding1], encoding2)
    return {"match": results[0]}

if __name__ == "__main__":
    if len(sys.argv) != 3:
        print(json.dumps({"error": "Invalid number of arguments"}))
        sys.exit(1)

    photo_path1 = sys.argv[1]
    photo_path2 = sys.argv[2]
    print("Photo 1 path:", photo_path1)
    print("Photo 2 path:", photo_path2)

    result = verify_face(photo_path1, photo_path2)
    print(json.dumps(result))
