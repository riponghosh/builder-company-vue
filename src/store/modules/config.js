const state = {
  experience: [
    { value: "0-1", label: "Under 1" },
    { value: "1-3", label: "1-3" },
    { value: "3-5", label: "3-5" },
    { value: "5+", label: "5+" },
  ],
  skills: [
    { value: "UI", label: "UI" },
    { value: "UX", label: "UX" },
    { value: "Design", label: "Design" },
    { value: "Illustrator", label: "Illustrator" },
    { value: "Photoshop", label: "Photoshop" },
    { value: "XD", label: "XD" },
    { value: "Sketch", label: "Sketch" }
  ],
  site: [
    { value: "On-Site", label: "On-Site" },
    { value: "Off-Site", label: "Off-Site" },
  ],
  jobTypes: [
    { value: "Freelance On-going", label: "Freelance On-going" },
    { value: "Freelance One Time", label: "Freelance One Time" },
    { value: "Full-time", label: "Full-time" },
  ],
  category: [{
    label: 'Advertising',
    value: 'advertising',
    list: [
      'Motion Graphics Designer',
      'Graphic Designer',
      'Animator',
      'Copywriter',
      'Producers',
      'Set Designers',
      'Typographers',
      'Art Directors',
      'Technical Artist',
      'FX Artist',
      'Compositor',
      'Lighter',
      '3D Artist',
      'Industrial Designers',
      'User Acquisition designer',
      'Other',
    ],
  }, {
    label: 'Game',
    value: 'game',
    list: [
      'Story writer',
      'Game Designer',
      'UI/UX designer',
      'Concept Artist',
      '3D Artist',
      '3D Modelers',
      'Texture Artist',
      'Shader Artist',
      'Rigger',
      'Animator',
      'Lighter',
      'Game Engine Artist',
      'Game Engine Engineer',
      'Technical Artist',
    ],
  }, {
    label: 'Technology Development',
    value: 'technology-development',
    list: [
      'UI Designer',
      'UX Designer',
      'Web Designer',
      'Front-End Web Developer',
      'Back- End Web Developer',
      'Full-deck Developer',
      'App Developer',
      'Product Designer',
      'Interactive Designer',
    ],
  }, {
    label: 'Animation',
    value: 'animation',
    list: [
      'Writer',
      'Storyboard Artist',
      'Visual Development Artist',
      '3D Artist',
      'Lighter',
      'Shader Artist',
      'Texture Artist',
      'VFX Artist',
      'Technical Artist',
      'Compositing Artist',
      'Matt Painter',
      'Render engine engineer',
      'Producers',
    ],
  }, {
    label: 'Drawing',
    value: 'drawing',
    list: [
      'Illustration',
      'Comic',
      'Matt Painter',
    ],
  }, {
    label: 'Production',
    value: 'production',
    list: [
      'Event Producers',
      'Cinematographers',
      'Storyboard Artist',
      'Directors',
      'Editors',
      'Producers',
      'Set Designers',
      'VFX Artist',
      'Content Producer',
      'Executive producers',
      'Art Producers',
    ],
  }, {
    label: 'Photography',
    value: 'photography',
    list: [
      'Artist',
      'Photographer',
      'Retouchers',
      'Art Producer',
    ],
  }, {
    label: 'Music',
    value: 'music',
    list: [
      'Composer'
    ],
  }],
}

const getters = {
  defaultCategory(state) {
    return state.category[0]
  },
}

const mutations = {}

const actions = {}

export default {
  state,
  getters,
  mutations,
  actions,
}
